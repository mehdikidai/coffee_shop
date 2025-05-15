import express from "express";
import { db } from "../data/db.js";

const router = express.Router();

router.get("/", (req, res) => {
  res.json(db.categories || []);
});


export default router