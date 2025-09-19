<?php
require_once 'Database.php';

/**
 * Class for handling Subcategory-related operations.
 * Inherits CRUD methods from the Database class.
 */
class Subcategory extends Database {

    /**
     * Creates a new Subcategory.
     * @param int $category_id The parent category ID.
     * @param string $subcategory_name The subcategory name.
     * @param string $subcategory_description The subcategory description.
     * @return bool True on success, false on failure.
     */
    public function createSubcategory($category_id, $subcategory_name, $subcategory_description) {
        $sql = "INSERT INTO subcategories (category_id, subcategory_name, subcategory_description) VALUES (?, ?, ?)";
        try {
            $this->executeNonQuery($sql, [$category_id, $subcategory_name, $subcategory_description]);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * Retrieves subcategories from the database.
     * @param int|null $id The subcategory ID to retrieve, or null for all subcategories.
     * @param int|null $category_id Optional category ID to filter subcategories.
     * @return array
     */
    public function getSubcategories($id = null, $category_id = null) {
        if ($id) {
            $sql = "SELECT s.*, c.category_name FROM subcategories s
                    JOIN categories c ON s.category_id = c.category_id
                    WHERE s.subcategory_id = ?";
            return $this->executeQuerySingle($sql, [$id]);
        }

        if ($category_id) {
            $sql = "SELECT s.*, c.category_name FROM subcategories s
                    JOIN categories c ON s.category_id = c.category_id
                    WHERE s.category_id = ?
                    ORDER BY s.subcategory_name ASC";
            return $this->executeQuery($sql, [$category_id]);
        }

        $sql = "SELECT s.*, c.category_name FROM subcategories s
                JOIN categories c ON s.category_id = c.category_id
                ORDER BY c.category_name ASC, s.subcategory_name ASC";
        return $this->executeQuery($sql);
    }

    /**
     * Updates a subcategory.
     * @param int $id The subcategory ID to update.
     * @param int $category_id The parent category ID.
     * @param string $subcategory_name The new subcategory name.
     * @param string $subcategory_description The new subcategory description.
     * @return bool True on success, false on failure.
     */
    public function updateSubcategory($id, $category_id, $subcategory_name, $subcategory_description) {
        $sql = "UPDATE subcategories SET category_id = ?, subcategory_name = ?, subcategory_description = ? WHERE subcategory_id = ?";
        try {
            $this->executeNonQuery($sql, [$category_id, $subcategory_name, $subcategory_description, $id]);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * Deletes a subcategory.
     * @param int $id The subcategory ID to delete.
     * @return bool True on success, false on failure.
     */
    public function deleteSubcategory($id) {
        $sql = "DELETE FROM subcategories WHERE subcategory_id = ?";
        try {
            $this->executeNonQuery($sql, [$id]);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * Checks if a subcategory name already exists within a category.
     * @param string $subcategory_name The subcategory name to check.
     * @param int $category_id The category ID.
     * @param int $exclude_id Optional subcategory ID to exclude from check.
     * @return bool True if subcategory name exists, false otherwise.
     */
    public function subcategoryNameExists($subcategory_name, $category_id, $exclude_id = null) {
        if ($exclude_id) {
            $sql = "SELECT COUNT(*) as count FROM subcategories WHERE subcategory_name = ? AND category_id = ? AND subcategory_id != ?";
            $result = $this->executeQuerySingle($sql, [$subcategory_name, $category_id, $exclude_id]);
        } else {
            $sql = "SELECT COUNT(*) as count FROM subcategories WHERE subcategory_name = ? AND category_id = ?";
            $result = $this->executeQuerySingle($sql, [$subcategory_name, $category_id]);
        }
        return $result && $result['count'] > 0;
    }
}
?>