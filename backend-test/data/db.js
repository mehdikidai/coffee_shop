import fs from "fs";
import path from "path";
const dbPath = path.resolve("./db.json");
const rawData = fs.readFileSync(dbPath);
export const db = JSON.parse(rawData);