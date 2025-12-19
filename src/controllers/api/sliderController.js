const Slider = require("../../models/Slider");

/* =========================
   GET ALL ACTIVE SLIDERS
========================= */
exports.list = async (req, res) => {
  try {
    const sliders = await Slider.findAll({
      where: { status: 1 },
      order: [["id", "DESC"]]
    });

    return res.json({
      status: true,
      data: sliders
    });
  } catch (err) {
    return res.status(500).json({
      status: false,
      message: err.message
    });
  }
};

/* =========================
   CREATE SLIDER (TEMP / ADMIN USE)
========================= */
exports.create = async (req, res) => {
  try {
    const { title, image, link } = req.body;

    if (!image) {
      return res.status(400).json({
        status: false,
        message: "Image is required"
      });
    }

    const slider = await Slider.create({
      title,
      image,
      link
    });

    return res.json({
      status: true,
      message: "Slider created",
      data: slider
    });

  } catch (err) {
    return res.status(500).json({
      status: false,
      message: err.message
    });
  }
};
