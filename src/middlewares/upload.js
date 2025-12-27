const multer = require("multer");
const path = require("path");

/* =========================
   STORAGE CONFIG
========================= */
const storage = multer.diskStorage({
  destination: function (req, file, cb) {
    cb(null, path.join(__dirname, "../public/uploads"));
  },
  filename: function (req, file, cb) {
    const uniqueName =
      Date.now() + "-" + Math.round(Math.random() * 1e9);
    cb(
      null,
      uniqueName + path.extname(file.originalname)
    );
  }
});

/* =========================
   FILE FILTER
========================= */
const fileFilter = (req, file, cb) => {
  const allowed = /jpg|jpeg|png|webp/;
  const ext = allowed.test(
    path.extname(file.originalname).toLowerCase()
  );
  const mime = allowed.test(file.mimetype);

  if (ext && mime) {
    cb(null, true);
  } else {
    cb(new Error("Only images allowed"));
  }
};

/* =========================
   EXPORT MULTER
========================= */
const upload = multer({
  storage,
  fileFilter
});

module.exports = upload;
