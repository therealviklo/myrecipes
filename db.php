<?php
	function getUserInfo($username) {
		$db = new SQLite3("db/project.db");
		if (!($stmt = $db->prepare("SELECT * FROM Users WHERE Username=:username"))) {
			$db->close();
			return false;
		}
		$stmt->bindParam(":username", $username, SQLITE3_TEXT);
		if (!($res = $stmt->execute())) {
			$db->close();
			return false;
		}
		if ($arr = $res->fetchArray()) {
			$db->close();
			return $arr;
		} else {
			$db->close();
			return false;
		}
	}

	function getUserInfoFromId($id) {
		$db = new SQLite3("db/project.db");
		if (!($stmt = $db->prepare("SELECT * FROM Users WHERE Id=:id"))) {
			$db->close();
			return false;
		}
		$stmt->bindParam(":id", $id, SQLITE3_INTEGER);
		if (!($res = $stmt->execute())) {
			$db->close();
			return false;
		}
		if ($arr = $res->fetchArray()) {
			$db->close();
			return $arr;
		} else {
			$db->close();
			return false;
		}
	}

	function isModerator($username) {
		if (!($userInfo = getUserInfo($username))) {
			return false;
		}
		return $userInfo["Moderator"] == 1;
	}

	function registerUser($username, $password) {
		$db = new SQLite3("db/project.db");
		if (!($stmt = $db->prepare("INSERT INTO Users (Username, Password) VALUES (:username, :password)"))) {
			$db->close();
			return false;
		}
		$stmt->bindParam(":username", $username, SQLITE3_TEXT);
		$hashedpassword = password_hash($password, PASSWORD_DEFAULT);
		$stmt->bindParam(":password", $hashedpassword, SQLITE3_TEXT);
		if ($stmt->execute()) {
			$db->close();
			return true;
		} else {
			$db->close();
			return false;
		}
	}

	function updatePassword($userid, $newpassword) {
		$db = new SQLite3("db/project.db");
		if (!($stmt = $db->prepare("UPDATE Users SET Password = :password WHERE Id = :id"))) {
			$db->close();
			return false;
		}
		$hashedpassword = password_hash($newpassword, PASSWORD_DEFAULT);
		$stmt->bindParam(":password", $hashedpassword, SQLITE3_TEXT);
		$stmt->bindParam(":id", $userid, SQLITE3_INTEGER);
		if ($stmt->execute()) {
			$db->close();
			return true;
		} else {
			$db->close();
			return false;
		}
	}

	function createPost($userid, $title, $ingredients, $description, $allergens, $knownAllergens) {
		$db = new SQLite3("db/project.db");
		if (!($stmt = $db->prepare("INSERT INTO Posts (UserId, Title, Ingredients, Description, Time, Allergens, knownAllergens) VALUES (:userid, :title, :ingredients, :description, datetime(), :allergens, :knownallergens)"))) {
			$db->close();
			return false;
		}
		$stmt->bindParam(":userid", $userid, SQLITE3_INTEGER);
		$stmt->bindParam(":title", $title, SQLITE3_TEXT);
		$stmt->bindParam(":ingredients", $ingredients, SQLITE3_TEXT);
		$stmt->bindParam(":description", $description, SQLITE3_TEXT);
		$stmt->bindParam(":allergens", $allergens, SQLITE3_TEXT);
		$stmt->bindParam(":knownallergens", $knownAllergens, SQLITE3_TEXT);
		if ($stmt->execute()) {
			$rowId = $db->lastInsertRowID();
			$db->close();
			return $rowId;
		} else {
			$db->close();
			return false;
		}
	}

	function addPostPicture($postId, $pictureName) {
		$db = new SQLite3("db/project.db");
		if (!($stmt = $db->prepare("INSERT INTO PostPictures (Id, FileName) VALUES (:id, :filename)"))) {
			$db->close();
			return false;
		}
		$stmt->bindParam(":id", $postId, SQLITE3_INTEGER);
		$stmt->bindParam(":filename", $pictureName, SQLITE3_TEXT);
		if ($stmt->execute()) {
			$db->close();
			return true;
		} else {
			$db->close();
			return false;
		}
	}

	function extractResults($result) {
		$results = array();
		while ($curr = $result->fetchArray()) {
			$results[] = $curr;
		}
		return $results;
	}
	
	function searchTitle($term){
		$db = new SQLite3("db/project.db");
		if (!($stmt = $db->prepare("SELECT Posts.Id AS Id, Users.Id AS UserId, Users.Username, Posts.Title, Posts.Ingredients, Posts.Description, Posts.Time, Posts.Approved, Posts.Allergens, Posts.knownAllergens FROM Posts INNER JOIN Users ON Posts.UserId = Users.Id WHERE Approved = 1 AND Title LIKE :search ORDER BY Time DESC"))) {
			$db->close();
			return false;
		}
		$stmt->bindValue(':search', "%" . $term . "%", SQLITE3_TEXT);
		if ($result = $stmt->execute()) {
			$results = extractResults($result);
			$db->close();
			return $results;
		} else {
			$db->close();
			return false;
		}
	}

	function getRecentPosts($num) {
		$db = new SQLite3("db/project.db");
		if (!($stmt = $db->prepare("SELECT Posts.Id AS Id, Users.Id AS UserId, Users.Username, Posts.Title, Posts.Ingredients, Posts.Description, Posts.Time, Posts.Approved, Posts.Allergens, Posts.knownAllergens FROM Posts INNER JOIN Users ON Posts.UserId = Users.Id WHERE Approved = 1 ORDER BY Time DESC LIMIT :num"))) {
			$db->close();
			return false;
		}
		$stmt->bindParam(":num", $num, SQLITE3_INTEGER);
		if ($res = $stmt->execute()) {
			$results = extractResults($res);
			$db->close();
			return $results;
		} else {
			$db->close();
			return false;
		}
	}

	function getUnapprovedPosts($num) {
		$db = new SQLite3("db/project.db");
		if (!($stmt = $db->prepare("SELECT Posts.Id AS Id, Users.Id AS UserId, Users.Username, Posts.Title, Posts.Ingredients, Posts.Description, Posts.Time, Posts.Approved, Posts.Allergens, Posts.knownAllergens FROM Posts INNER JOIN Users ON Posts.UserId = Users.Id WHERE Approved = 0 ORDER BY Time DESC LIMIT :num"))) {
			$db->close();
			return false;
		}
		$stmt->bindParam(":num", $num, SQLITE3_INTEGER);
		if ($res = $stmt->execute()) {
			$results = extractResults($res);
			$db->close();
			return $results;
		} else {
			$db->close();
			return false;
		}
	}

	function getPictures($id) {
		$db = new SQLite3("db/project.db");
		if (!($stmt = $db->prepare("SELECT FileName FROM PostPictures INNER JOIN Posts ON PostPictures.Id = Posts.Id WHERE PostPictures.Id = :id"))) {
			$db->close();
			return false;
		}
		$stmt->bindParam(":id", $id, SQLITE3_INTEGER);
		if ($res = $stmt->execute()) {
			$results = extractResults($res);
			$db->close();
			return $results;
		} else {
			$db->close();
			return false;
		}
	}

	function getPost($id) {
		$db = new SQLite3("db/project.db");
		if (!($stmt = $db->prepare("SELECT Posts.Id AS Id, Users.Id AS UserId, Users.Username, Posts.Title, Posts.Ingredients, Posts.Description, Posts.Time, Posts.Approved, Posts.Allergens, Posts.knownAllergens FROM Posts INNER JOIN Users ON Posts.UserId = Users.Id WHERE Posts.Id = :id"))) {
			$db->close();
			return false;
		}
		$stmt->bindParam(":id", $id, SQLITE3_INTEGER);
		if ($res = $stmt->execute()) {
			if ($arr = $res->fetchArray()) {
				$db->close();
				return $arr;
			} else {
				$db->close();
				return false;
			}
		} else {
			$db->close();
			return false;
		}
	}

	function approvePost($id) {
		$db = new SQLite3("db/project.db");
		if (!($stmt = $db->prepare("UPDATE Posts SET Approved = 1 WHERE Id = :id"))) {
			$db->close();
			return false;
		}
		$stmt->bindParam(":id", $id, SQLITE3_INTEGER);
		if ($stmt->execute()) {
			$db->close();
			return true;
		} else {
			$db->close();
			return false;
		}
	}

	function createComment($postid, $userid, $comment) {
		$db = new SQLite3("db/project.db");
		if (!($stmt = $db->prepare("INSERT INTO Comments (UserID, PostID, Comment) VALUES (:userid, :postid, :comment)"))) {
			$db->close();
			return false;
		}
		$stmt->bindParam(":userid", $userid, SQLITE3_INTEGER);
		$stmt->bindParam(":postid", $postid, SQLITE3_INTEGER);
		$stmt->bindParam(":comment", $comment, SQLITE3_TEXT);
		if ($stmt->execute()) {
			$db->close();
			return true;
		} else {
			$db->close();
			return false;
		}
	}

	function getComments($id) {
		$db = new SQLite3("db/project.db");
		if (!($stmt = $db->prepare("SELECT Comments.CommentID, Comments.UserID, Comments.PostID, Comments.Comment, Users.Username FROM Comments INNER JOIN Users ON Users.Id = Comments.UserID WHERE Comments.PostID = :id"))) {
			$db->close();
			return false;
		}
		$stmt->bindParam(":id", $id, SQLITE3_INTEGER);
		if ($res = $stmt->execute()) {
			$results = extractResults($res);
			$db->close();
			return $results;
		} else {
			$db->close();
			return false;
		}
	}

	function getComment($commentId) {
		$db = new SQLite3("db/project.db");
		if (!($stmt = $db->prepare("SELECT Comments.CommentID, Comments.UserID, Comments.PostID, Comments.Comment, Users.Username FROM Comments INNER JOIN Users ON Users.Id = Comments.UserID WHERE Comments.CommentID = :id"))) {
			echo "a";
			$db->close();
			return false;
		}
		$stmt->bindParam(":id", $commentId, SQLITE3_INTEGER);
		if ($res = $stmt->execute()) {
			if ($comment = $res->fetchArray()) {
				$db->close();
				return $comment;
			} else {
				$db->close();
				return false;
			}
		} else {
			$db->close();
			return false;
		}
	}

	function deleteComment($id) {
		$db = new SQLite3("db/project.db");
		if (!($stmt = $db->prepare("DELETE FROM Comments WHERE CommentID = :id"))) {
			$db->close();
			return false;
		}
		$stmt->bindParam(":id", $id, SQLITE3_INTEGER);
		if ($stmt->execute()) {
			$db->close();
			return true;
		} else {
			$db->close();
			return false;
		}
	}

	function deletePostComments($postid) {
		$db = new SQLite3("db/project.db");
		if (!($stmt = $db->prepare("DELETE FROM Comments WHERE PostID = :id"))) {
			$db->close();
			return false;
		}
		$stmt->bindParam(":id", $postid, SQLITE3_INTEGER);
		if ($stmt->execute()) {
			$db->close();
			return true;
		} else {
			$db->close();
			return false;
		}
	}

	function deleteUserComments($userid) {
		$db = new SQLite3("db/project.db");
		if (!($stmt = $db->prepare("DELETE FROM Comments WHERE UserID = :id"))) {
			$db->close();
			return false;
		}
		$stmt->bindParam(":id", $userid, SQLITE3_INTEGER);
		if ($stmt->execute()) {
			$db->close();
			return true;
		} else {
			$db->close();
			return false;
		}
	}

	function deletePostPictureFiles($id) {
		if (!($pictures = getPictures($id))) {
			return false;
		}
		foreach ($pictures as $pic) {
			unlink($pic["FileName"]);
		}
		return true;
	}

	function deletePostPictures($id) {
		$db = new SQLite3("db/project.db");
		if (!($stmt = $db->prepare("DELETE FROM PostPictures WHERE Id = :id"))) {
			$db->close();
			return false;
		}
		$stmt->bindParam(":id", $id, SQLITE3_INTEGER);
		if ($stmt->execute()) {
			$db->close();
			return true;
		} else {
			$db->close();
			return false;
		}
	}

	function deletePost($id) {
		$db = new SQLite3("db/project.db");
		if (!($stmt = $db->prepare("DELETE FROM Posts WHERE Id = :id"))) {
			$db->close();
			return false;
		}
		$stmt->bindParam(":id", $id, SQLITE3_INTEGER);
		if ($stmt->execute()) {
			$db->close();
			return true;
		} else {
			$db->close();
			return false;
		}
	}

	function deletePostAndAssociatedData($id) {
		deletePostPictureFiles($id);
		deletePostPictures($id);
		deletePostComments($id);
		deletePost($id);
	}

	function getUserPostIds($id) {
		$db = new SQLite3("db/project.db");
		if (!($stmt = $db->prepare("SELECT Posts.Id AS Id FROM Posts INNER JOIN Users ON Posts.UserId = Users.Id WHERE Users.Id = :id"))) {
			$db->close();
			return false;
		}
		$stmt->bindParam(":id", $id, SQLITE3_INTEGER);
		if ($res = $stmt->execute()) {
			$results = extractResults($res);
			$db->close();
			return $results;
		} else {
			$db->close();
			return false;
		}
	}

	function deleteUserPosts($id) {
		deleteUserComments($id);
		if ($userPostIds = getUserPostIds($id)) {
			foreach ($userPostIds as $upi) {
				deletePostAndAssociatedData($upi["Id"]);
			}
		}
	}

	function deleteUser($id) {
		$db = new SQLite3("db/project.db");
		if (!($stmt = $db->prepare("DELETE FROM Users WHERE Id = :id"))) {
			$db->close();
			return false;
		}
		$stmt->bindParam(":id", $id, SQLITE3_INTEGER);
		if ($stmt->execute()) {
			$db->close();
			return true;
		} else {
			$db->close();
			return false;
		}
	}

	function deleteUserAndAssociatedData($id) {
		deleteUserPosts($id);
		deleteUser($id);
	}

	function makeModerator($id) {
		$db = new SQLite3("db/project.db");
		if (!($stmt = $db->prepare("UPDATE Users SET Moderator = 1 WHERE Id = :id"))) {
			$db->close();
			return false;
		}
		$stmt->bindParam(":id", $id, SQLITE3_INTEGER);
		if ($stmt->execute()) {
			$db->close();
			return true;
		} else {
			$db->close();
			return false;
		}
	}
?>