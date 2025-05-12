import express from "express";
import { db } from "./../data/db.js";
import { auth } from "./../middleware/auth.js";

const router = express.Router();

router.use(auth);

router.get("/", (req, res) => {
  res.json(db.products || []);
});

router.get("/:categoryId", (req, res) => {
  const categoryId = parseInt(req.params.categoryId);

  const categoryExists = db.categories.some((cat) => cat.id === categoryId);
  if (!categoryExists) {
    return res.status(404).json({ message: "Category not found" });
  }

  const filteredProducts = (db.products || []).filter(
    (product) => product.categoryId === categoryId
  );

  res.json(filteredProducts);
});

export default router;
