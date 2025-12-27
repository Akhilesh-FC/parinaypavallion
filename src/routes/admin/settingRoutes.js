const express = require("express");
const router = express.Router();
const controller = require("../../controllers/admin/settingController");
const adminAuth = require("../../middlewares/adminAuth");

router.get("/profile", adminAuth, controller.profile);
router.post("/profile", adminAuth, controller.updateProfile);

router.get("/change-password", adminAuth, controller.changePasswordForm);
router.post("/change-password", adminAuth, controller.changePassword);

router.get("/logout", adminAuth, controller.logout);

module.exports = router;
