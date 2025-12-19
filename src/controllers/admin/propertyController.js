const Property = require("../../models/Property");

exports.create = async (req, res) => {
  await Property.create(req.body);
  res.json({ status: true, message: "Property added" });
};
