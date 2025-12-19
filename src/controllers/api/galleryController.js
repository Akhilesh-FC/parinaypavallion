const Gallery = require("../../models/Gallery");

exports.list = async (req, res) => {
  const data = await Gallery.findAll();
  res.json({ status: true, data });
};
