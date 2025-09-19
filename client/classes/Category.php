<?php
require_once 'Database.php';

/**
 * Class for handling Category-related operations.
 * Inherits CRUD methods from the Database class.
 */
class Category extends Database {

    /**
     * Creates a new Category.
     * @param string $category_name The category name.
     * @param string $category_description The category description.
     * @return bool True on success, false on failure.
     */
    public function createCategory($category_name, $category_description) {
        $sql = "INSERT INTO categories (category_name, category_description) VALUES (?, ?)";
        try {
            $this->executeNonQuery($sql, [$category_name, $category_description]);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * Retrieves categories from the database.
     * @param int|null $id The category ID to retrieve, or null for all categories.
     * @return array
     */
    public function getCategories($id = null) {
        if ($id) {
            $sql = "SELECT * FROM categories WHERE category_id = ?";
            return $this->executeQuerySingle($sql, [$id]);
        }
        $sql = "SELECT * FROM categories ORDER BY category_name ASC";
        return $this->executeQuery($sql);
    }

    /**
     * Updates a category.
     * @param int $id The category ID to update.
     * @param string $category_name The new category name.
     * @param string $category_description The new category description.
     * @return bool True on success, false on failure.
     */
    public function updateCategory($id, $category_name, $category_description) {
        $sql = "UPDATE categories SET category_name = ?, category_description = ? WHERE category_id = ?";
        try {
            $this->executeNonQuery($sql, [$category_name, $category_description, $id]);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * Deletes a category.
     * @param int $id The category ID to delete.
     * @return bool True on success, false on failure.
     */
    public function deleteCategory($id) {
        $sql = "DELETE FROM categories WHERE category_id = ?";
        try {
            $this->executeNonQuery($sql, [$id]);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * Checks if a category name already exists.
     * @param string $category_name The category name to check.
     * @param int $exclude_id Optional category ID to exclude from check.
     * @return bool True if category name exists, false otherwise.
     */
    public function categoryNameExists($category_name, $exclude_id = null) {
        if ($exclude_id) {
            $sql = "SELECT COUNT(*) as count FROM categories WHERE category_name = ? AND category_id != ?";
            $result = $this->executeQuerySingle($sql, [$category_name, $exclude_id]);
        } else {
            $sql = "SELECT COUNT(*) as count FROM categories WHERE category_name = ?";
            $result = $this->executeQuerySingle($sql, [$category_name]);
        }
        return $result && $result['count'] > 0;
    }
}
?>