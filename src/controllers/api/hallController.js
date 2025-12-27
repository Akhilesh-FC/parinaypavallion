const { Property, PropertyImage } = require("../../models");

/* =========================
   GET ALL HALLS
========================= */
exports.listHalls = async (req, res) => {
  try {
    const halls = await Property.findAll({
      where: {
        type: "hall",
        status: 1
      },
      attributes: [
        "id",
        "name",
        "description",
        "base_price",
        "min_guests",
        "max_guests"
      ],
      include: [
        {
          model: PropertyImage,
          as: "images",
          attributes: ["image"],
          limit: 1
        }
      ],
      order: [["base_price", "DESC"]]
    });

    return res.json({
      status: true,
      data: halls
    });

  } catch (err) {
    return res.status(500).json({
      status: false,
      message: err.message
    });
  }
};
