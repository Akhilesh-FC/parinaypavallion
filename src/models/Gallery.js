const { DataTypes } = require("sequelize");
const sequelize = require("../config/database");

module.exports = sequelize.define("gallery", {
  image: DataTypes.STRING,
  type: DataTypes.STRING
}, { timestamps: false });
