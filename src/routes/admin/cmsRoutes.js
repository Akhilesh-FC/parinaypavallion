const express = require("express");
const router = express.Router();
const cms = require("../../controllers/admin/cmsController");
const upload = require("../../middlewares/upload"); // multer

/* =========================
   PHOTO GALLERY
========================= */
router.get("/gallery", cms.galleryList);
router.post("/gallery/add", upload.single("image"), cms.galleryStore);
router.get("/gallery/delete/:id", cms.galleryDelete);

router.get("/gallery/edit/:id", cms.galleryEditForm);
router.post(
  "/gallery/edit/:id",
  upload.single("image"),
  cms.galleryUpdate     // ✅ FIXED
);

/* =========================
   SLIDERS
========================= */
// router.get("/sliders", cms.sliderList);
// router.post("/sliders/add", upload.single("image"), cms.sliderStore);
// router.get("/sliders/delete/:id", cms.sliderDelete);

router.get("/sliders", cms.sliderList);
router.post("/sliders/add", upload.single("image"), cms.sliderStore);
router.post("/sliders/update/:id", upload.single("image"), cms.sliderUpdate);


module.exports = router;
