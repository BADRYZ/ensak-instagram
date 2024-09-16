<?php 

include('../../connection.php');
session_start();

// Gestion de l'envoi des fichiers
if(isset($_POST['submit'])) {
    // Chemin temporaire du fichier téléchargé
    $file_tmp = $_FILES['file']['tmp_name'];
    // Nom du fichier téléchargé
    $file_name = $_FILES['file']['name'];
    // Dossier de destination permanent
    $destination_folder = 'uploads/';

    if ($file_tmp && $file_name) {
        // Chemin de destination permanent pour le fichier
        $file_path = $destination_folder . $file_name;

        // Déplacer le fichier téléchargé vers le dossier permanent
        if (move_uploaded_file($file_tmp, $file_path)) {
            // Lire le contenu du fichier
            $file_content = file_get_contents($file_path);
            // Echapper le contenu pour la base de données
            $file_content = $conn->real_escape_string($file_content);
            // Insérer les informations dans la base de données
            $sql = "INSERT INTO files (file_name, file_path, file) VALUES ('$file_name', '$file_path', '$file_content')";
            if ($conn->query($sql) === TRUE) {
                // Obtenez l'ID du fichier inséré
                $file_id = $conn->insert_id;

                // Obtenez la date et l'heure actuelles
                $date_time = date("Y-m-d H:i:s");

                // Obtenez l'ID de l'utilisateur (vous devrez probablement définir $user_id auparavant)
                $user_id = $_SESSION['user_id']; // Exemple de valeur, veuillez ajuster en fonction de votre application

                // Obtenez la légende du poste à partir du formulaire
                $caption = $conn->real_escape_string($_POST['caption']);

                // Here create a post id, with a function that generates ids in php
                $post_id = uniqid();

                // Insérez les données du message dans la table des publications
                $sql = "INSERT INTO posts (POST_ID, USER_ID, DATETIME_ADDED, CAPTION, image_id) VALUES ('$post_id','$user_id', '$date_time', '$caption', '$file_id')";
                if ($conn->query($sql) === TRUE) {

                    // Insérer les hashtags dans la table des hashtags (s'ils n'existent pas déjà)
                    if (!empty($_POST['hashtags'])) {
                        $hashtags_input = $_POST['hashtags'];
                        $hashtags_array = explode(",", $hashtags_input);
                        foreach ($hashtags_array as $hashtag) {
                            $hashtag = trim($hashtag); // Remove leading and trailing whitespace
                            $sql = "INSERT IGNORE INTO hashtags (hashtag) VALUES ('$hashtag')";
                            $conn->query($sql); // Ignorer les doublons
                        }

                        // Récupérer les ID des hashtags insérés
                        $hashtags_ids = [];
                        foreach ($hashtags_array as $hashtag) {
                            $hashtag = trim($hashtag); // Remove leading and trailing whitespace
                            $sql = "SELECT HASHTAG_ID FROM hashtags WHERE HASHTAG = '$hashtag'";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $hashtags_ids[] = $row['HASHTAG_ID'];
                            }
                        }

                        // Insérer les mappings entre la publication et ses hashtags dans la table des mappings des hashtags
                        foreach ($hashtags_ids as $hashtag_id) {
                            $sql = "INSERT INTO hashtagmappings (`POST_ID`, `HASHTAG_ID`, `DATETIME_ADDED`) VALUES ('$post_id', '$hashtag_id', '$date_time')";
                            $conn->query($sql);
                        }
                    }

                    header('location: ../views/home.php');
                    exit;
                } else {
                    echo "Error inserting post: " . $conn->error;
                }
            } else {
                echo "Error inserting file: " . $conn->error;
            }
        } else {
            echo "Error moving uploaded file: " . $_FILES['file']['error'];
        }
    } else {
        echo "Please select a file.";
    }
}

$conn->close();

?>
