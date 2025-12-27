const { Property, PropertyImage, Facility } = require("../../models");

/* =========================
   GET ALL WEDDING LAWNS
========================= */
exports.listLawns = async (req, res) => {
  try {
    const lawns = await Property.findAll({
      where: {
        type: "lawn",
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
          limit: 1   // 👈 only one image (card thumbnail)
        }
      ],
      order: [["base_price", "DESC"]]
    });

    return res.json({
      status: true,
      data: lawns
    });

  } catch (err) {
    return res.status(500).json({
      status: false,
      message: err.message
    });
  }
};




/* =========================
   SINGLE LAWN DETAILS
========================= */
exports.getLawnDetails = async (req, res) => {
  try {
    const { id } = req.params;

    const lawn = await Property.findOne({
      where: {
        id,
        type: "lawn",
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
          attributes: ["image"]
        },
        {
          model: Facility,
          as: "facilities",
          attributes: ["name"],
          through: { attributes: [] }
        }
      ]
    });

    if (!lawn) {
      return res.status(404).json({
        status: false,
        message: "Lawn not found"
      });
    }

    return res.json({
      status: true,
      data: lawn
    });

  } catch (err) {
    return res.status(500).json({
      status: false,
      message: err.message
    });
  }
};

