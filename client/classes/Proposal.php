<?php
/**
 * Class for handling Proposal-related operations.
 * Inherits CRUD methods from the Database class.
 */
class Proposal extends Database {
    /**
     * Creates a new Proposal.
     * @param int $user_id The user ID.
     * @param int $category_id The category ID.
     * @param int $subcategory_id The subcategory ID.
     * @param string $description The proposal description.
     * @param string $image The proposal image.
     * @param int $min_price The minimum price.
     * @param int $max_price The maximum price.
     * @return bool True on success, false on failure.
     */
    public function createProposal($user_id, $category_id, $subcategory_id, $description, $image, $min_price, $max_price) {
        $sql = "INSERT INTO Proposals (user_id, category_id, subcategory_id, description, image, min_price, max_price) VALUES (?, ?, ?, ?, ?, ?, ?)";
        try {
            $this->executeNonQuery($sql, [$user_id, $category_id, $subcategory_id, $description, $image, $min_price, $max_price]);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * Retrieves Proposals from the database.
     * @param int|null $id The Proposal ID to retrieve, or null for all Proposals.
     * @return array
     */
    public function getProposals($id = null) {
        if ($id) {
            $sql = "SELECT p.*, u.*, c.category_name, s.subcategory_name,
                    p.date_added AS proposals_date_added
                    FROM Proposals p
                    JOIN fiverr_clone_users u ON p.user_id = u.user_id
                    JOIN categories c ON p.category_id = c.category_id
                    JOIN subcategories s ON p.subcategory_id = s.subcategory_id
                    WHERE p.proposal_id = ?";
            return $this->executeQuerySingle($sql, [$id]);
        }
        $sql = "SELECT p.*, u.*, c.category_name, s.subcategory_name,
                p.date_added AS proposals_date_added
                FROM Proposals p
                JOIN fiverr_clone_users u ON p.user_id = u.user_id
                JOIN categories c ON p.category_id = c.category_id
                JOIN subcategories s ON p.subcategory_id = s.subcategory_id
                ORDER BY p.date_added DESC";
        return $this->executeQuery($sql);
    }

    public function getProposalsByUserID($user_id) {
        $sql = "SELECT p.*, u.*, c.category_name, s.subcategory_name,
                p.date_added AS proposals_date_added
                FROM Proposals p
                JOIN fiverr_clone_users u ON p.user_id = u.user_id
                JOIN categories c ON p.category_id = c.category_id
                JOIN subcategories s ON p.subcategory_id = s.subcategory_id
                WHERE p.user_id = ?
                ORDER BY p.date_added DESC";
        return $this->executeQuery($sql, [$user_id]);
    }

    /**
     * Retrieves Proposals filtered by category and/or subcategory.
     * @param int|null $category_id The category ID to filter by.
     * @param int|null $subcategory_id The subcategory ID to filter by.
     * @return array
     */
    public function getProposalsByCategory($category_id = null, $subcategory_id = null) {
        if ($category_id && $subcategory_id) {
            // Filter by both category and subcategory
            $sql = "SELECT p.*, u.*, c.category_name, s.subcategory_name,
                    p.date_added AS proposals_date_added
                    FROM Proposals p
                    JOIN fiverr_clone_users u ON p.user_id = u.user_id
                    JOIN categories c ON p.category_id = c.category_id
                    JOIN subcategories s ON p.subcategory_id = s.subcategory_id
                    WHERE p.category_id = ? AND p.subcategory_id = ?
                    ORDER BY p.date_added DESC";
            return $this->executeQuery($sql, [$category_id, $subcategory_id]);
        } elseif ($category_id) {
            // Filter by category only
            $sql = "SELECT p.*, u.*, c.category_name, s.subcategory_name,
                    p.date_added AS proposals_date_added
                    FROM Proposals p
                    JOIN fiverr_clone_users u ON p.user_id = u.user_id
                    JOIN categories c ON p.category_id = c.category_id
                    JOIN subcategories s ON p.subcategory_id = s.subcategory_id
                    WHERE p.category_id = ?
                    ORDER BY p.date_added DESC";
            return $this->executeQuery($sql, [$category_id]);
        } else {
            // No filters, return all proposals
            return $this->getProposals();
        }
    }

    /**
     * Updates an Proposal.
     * @param int $proposal_id The Proposal ID to update.
     * @param int $category_id The category ID.
     * @param int $subcategory_id The subcategory ID.
     * @param string $description The new description.
     * @param int $min_price The new minimum price.
     * @param int $max_price The new maximum price.
     * @param string $image The new image (optional).
     * @return bool True on success, false on failure.
     */
    public function updateProposal($proposal_id, $category_id, $subcategory_id, $description, $min_price, $max_price, $image = "") {
        if (!empty($image)) {
            $sql = "UPDATE Proposals SET category_id = ?, subcategory_id = ?, description = ?, image = ?, min_price = ?, max_price = ? WHERE proposal_id = ?";
            try {
                $this->executeNonQuery($sql, [$category_id, $subcategory_id, $description, $image, $min_price, $max_price, $proposal_id]);
                return true;
            } catch (\PDOException $e) {
                return false;
            }
        } else {
            $sql = "UPDATE Proposals SET category_id = ?, subcategory_id = ?, description = ?, min_price = ?, max_price = ? WHERE proposal_id = ?";
            try {
                $this->executeNonQuery($sql, [$category_id, $subcategory_id, $description, $min_price, $max_price, $proposal_id]);
                return true;
            } catch (\PDOException $e) {
                return false;
            }
        }
    }

    public function addViewCount($proposal_id) {
        $sql = "UPDATE Proposals SET view_count = view_count + 1 WHERE Proposal_id = ?";
        return $this->executeNonQuery($sql, [$proposal_id]);
    }

    /**
     * Deletes an Proposal.
     * @param int $id The Proposal ID to delete.
     * @return int The number of affected rows.
     */
    public function deleteProposal($id) {
        $sql = "DELETE FROM Proposals WHERE Proposal_id = ?";
        return $this->executeNonQuery($sql, [$id]);
    }
}
?>