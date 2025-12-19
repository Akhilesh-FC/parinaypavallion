const { DataTypes } = require("sequelize");
const sequelize = require("../config/database");

const Enquiry = sequelize.define("enquiries", {
  id: {
    type: DataTypes.INTEGER,
    autoIncrement: true,
    primaryKey: true
  },
  name: DataTypes.STRING,
  email: DataTypes.STRING,
  mobile: DataTypes.STRING,
  message: DataTypes.TEXT
}, {
  timestamps: true
});

module.exports = Enquiry;
