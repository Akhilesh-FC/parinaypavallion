const { DataTypes } = require("sequelize");
const sequelize = require("../config/database");

const PropertyAvailability = sequelize.define(
  "PropertyAvailability",
  {
    property_id: {
      type: DataTypes.BIGINT.UNSIGNED,
      allowNull: false
    },
    date: {
      type: DataTypes.DATEONLY,
      allowNull: false
    },
    time_slot: {
      type: DataTypes.STRING,
      allowNull: false
    },
    is_available: {
      type: DataTypes.TINYINT,
      defaultValue: 1
    }
  },
  {
    tableName: "property_availabilities", // ✅ EXACT TABLE NAME
    timestamps: false
  }
);

module.exports = PropertyAvailability;
