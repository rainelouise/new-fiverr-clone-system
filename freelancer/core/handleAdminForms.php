<?php
require_once '../classloader.php';

// Check if user is logged in and is a fiverr administrator
if (!$userObj->isLoggedIn() || !$userObj->isFiverrAdministrator()) {
    header("Location: ../login.php");
    exit();
}

// Handle Add Category
if (isset($_POST['addCategoryBtn'])) {
    $category_name = htmlspecialchars(trim($_POST['category_name']));
    $category_description = htmlspecialchars(trim($_POST['category_description']));

    if (!empty($category_name)) {
        if (!$categoryObj->categoryNameExists($category_name)) {
            if ($categoryObj->createCategory($category_name, $category_description)) {
                $_SESSION['message'] = "Category added successfully!";
                $_SESSION['status'] = '200';
            } else {
                $_SESSION['message'] = "Failed to add category.";
                $_SESSION['status'] = '400';
            }
        } else {
            $_SESSION['message'] = "Category name already exists.";
            $_SESSION['status'] = '400';
        }
    } else {
        $_SESSION['message'] = "Category name is required.";
        $_SESSION['status'] = '400';
    }
    header("Location: ../admin_dashboard.php");
    exit();
}

// Handle Update Category
if (isset($_POST['updateCategoryBtn'])) {
    $category_id = $_POST['category_id'];
    $category_name = htmlspecialchars(trim($_POST['category_name']));
    $category_description = htmlspecialchars(trim($_POST['category_description']));

    if (!empty($category_name)) {
        if (!$categoryObj->categoryNameExists($category_name, $category_id)) {
            if ($categoryObj->updateCategory($category_id, $category_name, $category_description)) {
                $_SESSION['message'] = "Category updated successfully!";
                $_SESSION['status'] = '200';
            } else {
                $_SESSION['message'] = "Failed to update category.";
                $_SESSION['status'] = '400';
            }
        } else {
            $_SESSION['message'] = "Category name already exists.";
            $_SESSION['status'] = '400';
        }
    } else {
        $_SESSION['message'] = "Category name is required.";
        $_SESSION['status'] = '400';
    }
    header("Location: ../admin_dashboard.php");
    exit();
}

// Handle Delete Category
if (isset($_POST['deleteCategoryBtn'])) {
    $category_id = $_POST['category_id'];

    if ($categoryObj->deleteCategory($category_id)) {
        $_SESSION['message'] = "Category deleted successfully!";
        $_SESSION['status'] = '200';
    } else {
        $_SESSION['message'] = "Failed to delete category.";
        $_SESSION['status'] = '400';
    }
    header("Location: ../admin_dashboard.php");
    exit();
}

// Handle Add Subcategory
if (isset($_POST['addSubcategoryBtn'])) {
    $category_id = $_POST['category_id'];
    $subcategory_name = htmlspecialchars(trim($_POST['subcategory_name']));
    $subcategory_description = htmlspecialchars(trim($_POST['subcategory_description']));

    if (!empty($subcategory_name) && !empty($category_id)) {
        if (!$subcategoryObj->subcategoryNameExists($subcategory_name, $category_id)) {
            if ($subcategoryObj->createSubcategory($category_id, $subcategory_name, $subcategory_description)) {
                $_SESSION['message'] = "Subcategory added successfully!";
                $_SESSION['status'] = '200';
            } else {
                $_SESSION['message'] = "Failed to add subcategory.";
                $_SESSION['status'] = '400';
            }
        } else {
            $_SESSION['message'] = "Subcategory name already exists in this category.";
            $_SESSION['status'] = '400';
        }
    } else {
        $_SESSION['message'] = "Subcategory name and category are required.";
        $_SESSION['status'] = '400';
    }
    header("Location: ../admin_dashboard.php");
    exit();
}

// Handle Update Subcategory
if (isset($_POST['updateSubcategoryBtn'])) {
    $subcategory_id = $_POST['subcategory_id'];
    $category_id = $_POST['category_id'];
    $subcategory_name = htmlspecialchars(trim($_POST['subcategory_name']));
    $subcategory_description = htmlspecialchars(trim($_POST['subcategory_description']));

    if (!empty($subcategory_name) && !empty($category_id)) {
        if (!$subcategoryObj->subcategoryNameExists($subcategory_name, $category_id, $subcategory_id)) {
            if ($subcategoryObj->updateSubcategory($subcategory_id, $category_id, $subcategory_name, $subcategory_description)) {
                $_SESSION['message'] = "Subcategory updated successfully!";
                $_SESSION['status'] = '200';
            } else {
                $_SESSION['message'] = "Failed to update subcategory.";
                $_SESSION['status'] = '400';
            }
        } else {
            $_SESSION['message'] = "Subcategory name already exists in this category.";
            $_SESSION['status'] = '400';
        }
    } else {
        $_SESSION['message'] = "Subcategory name and category are required.";
        $_SESSION['status'] = '400';
    }
    header("Location: ../admin_dashboard.php");
    exit();
}

// Handle Delete Subcategory
if (isset($_POST['deleteSubcategoryBtn'])) {
    $subcategory_id = $_POST['subcategory_id'];

    if ($subcategoryObj->deleteSubcategory($subcategory_id)) {
        $_SESSION['message'] = "Subcategory deleted successfully!";
        $_SESSION['status'] = '200';
    } else {
        $_SESSION['message'] = "Failed to delete subcategory.";
        $_SESSION['status'] = '400';
    }
    header("Location: ../admin_dashboard.php");
    exit();
}
?>