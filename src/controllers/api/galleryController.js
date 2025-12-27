const { Gallery } = require("../../models");

/* =========================
   GET GALLERY LIST
========================= */
exports.list = async (req, res) => {
  try {
    const { type } = req.query; // optional filter

    const where = {};
    if (type) {
      where.type = type;
    }

    const data = await Gallery.findAll({
      where,
      attributes: ["id", "image", "type", "created_at"],
      order: [["id", "DESC"]]
    });

    return res.json({
      status: true,
      data
    });

  } catch (err) {
    return res.status(500).json({
      status: false,
      message: err.message
    });
  }
};
