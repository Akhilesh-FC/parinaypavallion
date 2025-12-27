const { DataTypes } = require("sequelize");
const sequelize = require("../config/database");

const SocialLink = sequelize.define("social_links", {
  facebook: DataTypes.STRING,
  instagram: DataTypes.STRING
}, {
  timestamps: false
});

module.exports = SocialLink;
