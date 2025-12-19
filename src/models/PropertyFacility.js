const sequelize = require("../config/database");

module.exports = sequelize.define("property_facilities", {}, { timestamps: false });
