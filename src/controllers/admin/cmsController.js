const Gallery = require("../../models/Gallery");

/* =========================
   PHOTO GALLERY
========================= */


/* =========================
   LIST
========================= */
exports.galleryList = async (req, res) => {
  const images = await Gallery.findAll({ order: [["id", "DESC"]] });

  res.render("admin/cms/gallery/list", {
    title: "Gallery Management",
    images
  });
};

/* =========================
   EDIT FORM
========================= */
exports.galleryEditForm = async (req, res) => {
  const image = await Gallery.findByPk(req.params.id);

  res.render("admin/cms/gallery/edit", {
    title: "Update Gallery",
    image
  });
};

/* =========================
   UPDATE
========================= */
exports.galleryUpdate = async (req, res) => {
  const image = await Gallery.findByPk(req.params.id);

  if (req.file) {
    image.image = req.file.filename;
  }

  image.type = req.body.type;
  await image.save();

  res.redirect("/admin/cms/gallery");
};


exports.galleryStore = async (req, res) => {
  await Gallery.create({
    image: req.file.filename,
    type: "gallery"
  });

  res.redirect("/admin/cms/gallery");
};

exports.galleryDelete = async (req, res) => {
  await Gallery.destroy({ where: { id: req.params.id } });
  res.redirect("back");
};


/* =========================
   SLIDERS / BANNERS
========================= */
exports.sliderList = async (req, res) => {
  const sliders = await Gallery.findAll({
    where: { type: "slider" },
    order: [["id", "DESC"]]
  });

  res.render("admin/cms/sliders/list", {
    title: "Slider Management",
    sliders
  });
};


exports.sliderStore = async (req, res) => {
  await Gallery.create({
    image: req.file.filename,
    type: "slider"
  });

  res.redirect("/admin/cms/sliders");
};

exports.sliderDelete = async (req, res) => {
  await Gallery.destroy({ where: { id: req.params.id } });
  res.redirect("back");
};

exports.sliderUpdate = async (req, res) => {
  const slider = await Gallery.findByPk(req.params.id);

  if (req.file) {
    slider.image = req.file.filename;
  }

  await slider.save();
  res.redirect("/admin/cms/sliders");
};

