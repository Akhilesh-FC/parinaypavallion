
const sequelize = require("../../config/database");

const {
  Property,
  PropertyImage,
  Facility
} = require("../../models");


exports.list = async (req, res) => {
  try {
    const { type } = req.query;

    const properties = await Property.findAll({
      where: type ? { type } : {},
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

    return res.json({
      status: true,
      data: properties
    });

  } catch (err) {
    return res.status(500).json({
      status: false,
      message: err.message
    });
  }
};


exports.countProperties = async (req, res) => {
  try {
    const lawnCount = await Property.count({ where: { type: "lawn" } });
    const hallCount = await Property.count({ where: { type: "hall" } });
    const roomCount = await Property.count({ where: { type: "room" } });

    return res.json({
      status: true,
      data: {
        lawns: lawnCount,
        halls: hallCount,
        rooms: roomCount,
        total: lawnCount + hallCount + roomCount
      }
    });
  } catch (err) {
    return res.status(500).json({
      status: false,
      message: err.message
    });
  }
};


