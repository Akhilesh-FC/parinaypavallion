const Admin = require("../../models/Admin");

/* =========================
   LOGIN PAGE
========================= */
exports.loginPage = (req, res) => {
  res.render("admin/login", {
    title: "Admin Login",
    error: null
  });
};

/* =========================
   LOGIN ACTION (PLAIN PASSWORD)
========================= */
exports.login = async (req, res) => {
  try {
    const { email, password } = req.body;

    if (!email || !password) {
      return res.render("admin/login", {
        title: "Admin Login",
        error: "Email and password required"
      });
    }

    const admin = await Admin.findOne({ where: { email } });

    if (!admin) {
      return res.render("admin/login", {
        title: "Admin Login",
        error: "Invalid credentials"
      });
    }

    // ✅ PLAIN PASSWORD CHECK
    if (password !== admin.password) {
      return res.render("admin/login", {
        title: "Admin Login",
        error: "Invalid credentials"
      });
    }

    // ✅ SESSION SET
    req.session.admin = {
      id: admin.id,
      name: admin.name,
      email: admin.email
    };

    return res.redirect("/admin/dashboard");

  } catch (err) {
    console.error(err);
    return res.render("admin/login", {
      title: "Admin Login",
      error: "Something went wrong"
    });
  }
};

/* =========================
   LOGOUT
========================= */
exports.logout = (req, res) => {
  req.session.destroy(() => {
    res.redirect("/admin/login");
  });
};
