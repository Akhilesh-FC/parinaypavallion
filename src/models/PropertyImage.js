const { DataTypes } = require("sequelize");
const sequelize = require("../config/database");

const PropertyImage = sequelize.define("property_images", {
  property_id: {
    type: DataTypes.BIGINT.UNSIGNED,
    allowNull: false
  },
  image: DataTypes.STRING
}, { timestamps: false });

module.exports = PropertyImage;
