const { DataTypes } = require("sequelize");
const sequelize = require("../config/database");

const Property = sequelize.define("properties", {
  type: DataTypes.STRING,
  name: DataTypes.STRING,
  description: DataTypes.TEXT,
  min_guests: DataTypes.INTEGER,
  max_guests: DataTypes.INTEGER,
  base_price: DataTypes.DECIMAL,
  status: DataTypes.TINYINT
}, {
  timestamps: true,
  createdAt: "created_at",
  updatedAt: "updated_at"
});

module.exports = Property;
