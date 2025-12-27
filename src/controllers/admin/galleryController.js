
const {
  slider
} = require("../../models");
const { Op } = require("sequelize");

exports.list = async (req, res) => {
  const data = await Gallery.findAll({ order: [["id","DESC"]] });
  res.render("admin/gallery/list", { data });
};

exports.add = async (req, res) => {
  await Gallery.create({
    image: req.file.filename,
    type: req.body.type
  });
  res.redirect("/admin/gallery");
};
