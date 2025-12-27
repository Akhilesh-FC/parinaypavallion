const { Slider } = require("../../models");

/* =========================
   LIST
========================= */
exports.list = async (req, res) => {
  const sliders = await Slider.findAll({
    order: [["id", "DESC"]]
  });

  res.render("admin/cms/sliders/list", {
    title: "Slider Management",
    sliders
  });
};

/* =========================
   UPDATE
========================= */
exports.update = async (req, res) => {
  const slider = await Slider.findByPk(req.params.id);

  slider.title = req.body.title;
  slider.link = req.body.link;
  slider.status = req.body.status;

  if (req.file) {
    slider.image = req.file.filename;
  }

  await slider.save();
  res.redirect("/admin/cms/sliders");
};

/* =========================
   DELETE
========================= */
exports.delete = async (req, res) => {
  await Slider.destroy({ where: { id: req.params.id } });
  res.redirect("back");
};
