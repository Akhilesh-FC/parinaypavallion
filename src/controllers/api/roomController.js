const { Property, PropertyImage } = require("../../models");

/* =========================
   GET ALL ROOMS
========================= */
exports.listRooms = async (req, res) => {
  try {
    const rooms = await Property.findAll({
      where: {
        type: "room",
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
      order: [["base_price", "ASC"]]
    });

    return res.json({
      status: true,
      data: rooms
    });

  } catch (err) {
    return res.status(500).json({
      status: false,
      message: err.message
    });
  }
};
