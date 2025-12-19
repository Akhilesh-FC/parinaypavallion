const Service = require("../../models/Service");

/* =========================
   GET ALL ACTIVE SERVICES
========================= */
exports.list = async (req, res) => {
  try {
    const services = await Service.findAll({
      where: { status: 1 },
      order: [["id", "ASC"]]
    });

    return res.json({
      status: true,
      data: services
    });

  } catch (err) {
    return res.status(500).json({
      status: false,
      message: err.message
    });
  }
};

const {
  Property,
  PropertyImage
} = require("../../models");

/* =========================
   FEATURED VENUES LIST
========================= */
exports.featured_venue_list = async (req, res) => {
  try {
    const venues = await Property.findAll({
      where: {
        is_featured: 1,
        status: 1
      },
      attributes: [
        "id",
        "type",
        "name",
        "description",
        "min_guests",
        "max_guests",
        "base_price"
      ],
      include: [
        {
          model: PropertyImage,
          as: "images",
          attributes: ["image"],
          limit: 1   // 👈 only first image (thumbnail)
        }
      ],
      order: [["id", "DESC"]]
    });

    return res.json({
      status: true,
      data: venues
    });

  } catch (err) {
    return res.status(500).json({
      status: false,
      message: err.message
    });
  }
};
