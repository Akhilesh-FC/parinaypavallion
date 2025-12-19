const { DataTypes } = require("sequelize");
const sequelize = require("../config/database");

module.exports = sequelize.define("facilities", {
  name: DataTypes.STRING
}, { timestamps: false });
