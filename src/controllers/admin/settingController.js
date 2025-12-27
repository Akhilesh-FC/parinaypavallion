const { Admin } = require("../../models");

/* =========================
   PROFILE PAGE
========================= */
exports.profile = async (req, res) => {
  if (!req.session.admin) {
    return res.redirect("/admin/login");
  }

  const admin = await Admin.findByPk(req.session.admin.id);

  res.render("admin/settings/profile", {
    title: "My Profile",
    admin
  });
};

/* =========================
   UPDATE PROFILE
========================= */
exports.updateProfile = async (req, res) => {
  const { name, email } = req.body;

  await Admin.update(
    { name, email },
    { where: { id: req.session.admin.id } }
  );

  res.redirect("/admin/profile");
};

/* =========================
   CHANGE PASSWORD FORM
========================= */
exports.changePasswordForm = (req, res) => {
  res.render("admin/settings/change-password", {
    title: "Change Password",
    error: null,
    success: null
  });
};

/* =========================
   CHANGE PASSWORD
========================= */
exports.changePassword = async (req, res) => {
  const { old_password, new_password, confirm_password } = req.body;

  const admin = await Admin.findByPk(req.session.admin.id);

  if (admin.password !== old_password) {
    return res.render("admin/settings/change-password", {
      title: "Change Password",
      error: "Old password is incorrect",
      success: null
    });
  }

  if (new_password !== confirm_password) {
    return res.render("admin/settings/change-password", {
      title: "Change Password",
      error: "Passwords do not match",
      success: null
    });
  }

  admin.password = new_password;
  await admin.save();

  res.render("admin/settings/change-password", {
    title: "Change Password",
    error: null,
    success: "Password updated successfully"
  });
};

/* =========================
   LOGOUT
========================= */
exports.logout = (req, res) => {
  req.session.destroy(() => {
    res.redirect("/admin/login");
  });
};
