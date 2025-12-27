const {
  Property,
  Facility,
  PropertyFacility
} = require("../../models");

/* =========================
   LIST (LAWNS / HALLS / ROOMS)
========================= */
exports.listByType = async (req, res, type) => {
  try {
    const properties = await Property.findAll({
      where: { type },
      order: [["id", "DESC"]]
    });

    res.render("admin/properties/list", {
      title: `${type.toUpperCase()} Management`,
      type,
      properties
    });
  } catch (err) {
    res.send(err.message);
  }
};

/* =========================
   ADD FORM
========================= */
exports.addForm = async (req, res, type) => {
  try {
    const facilities = await Facility.findAll();

    res.render("admin/properties/add", {
  title: "Add Lawn",
  type: "lawn",
  facilities
});
  } catch (err) {
    res.send(err.message);
  }
};

/* =========================
   STORE
========================= */
exports.store = async (req, res, type) => {
  try {
    const {
      name,
      description,
      min_guests,
      max_guests,
      base_price,
      facilities = []
    } = req.body;

    const property = await Property.create({
      type,
      name,
      description,
      min_guests,
      max_guests,
      base_price,
      status: 1
    });

    if (facilities.length) {
      await PropertyFacility.bulkCreate(
        facilities.map(fid => ({
          property_id: property.id,
          facility_id: fid
        }))
      );
    }

    res.redirect(`/admin/${type}s`);
  } catch (err) {
    res.send(err.message);
  }
};

/* =========================
   EDIT FORM
========================= */
exports.editForm = async (req, res) => {
  try {
    const property = await Property.findByPk(req.params.id, {
      include: {
        model: Facility,
        as: "facilities"
      }
    });

    const facilities = await Facility.findAll();
    const selectedFacilities = property.facilities.map(f => f.id);

    res.render("admin/properties/edit", {
  title: "Edit Lawn",
  type: "lawn",
  property,
  facilities,
  selectedFacilities
});
  } catch (err) {
    res.send(err.message);
  }
};

/* =========================
   UPDATE
========================= */
exports.update = async (req, res) => {
  try {
    const {
      name,
      description,
      min_guests,
      max_guests,
      base_price,
      facilities = []
    } = req.body;

    await Property.update(
      { name, description, min_guests, max_guests, base_price },
      { where: { id: req.params.id } }
    );

    await PropertyFacility.destroy({
      where: { property_id: req.params.id }
    });

    if (facilities.length) {
      await PropertyFacility.bulkCreate(
        facilities.map(fid => ({
          property_id: req.params.id,
          facility_id: fid
        }))
      );
    }

    res.redirect(`/admin/${req.params.type}s`);
  } catch (err) {
    res.send(err.message);
  }
};

/* =========================
   DELETE
========================= */
exports.delete = async (req, res) => {
  try {
    await PropertyFacility.destroy({
      where: { property_id: req.params.id }
    });

    await Property.destroy({
      where: { id: req.params.id }
    });

    res.redirect("back");
  } catch (err) {
    res.send(err.message);
  }
};
