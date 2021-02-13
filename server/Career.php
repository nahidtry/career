<?php
class Career
{

    private $conn;

    public function __construct()
    {
        $server   = "localhost";
        $dbname   = "try_oms";
        $username = "root";
        $password = "";

        /* $server   = "localhost";
        $dbname   = "trybpoltd_office";
        $username = "trybpoltd_office";
        $password = "2?r+;45G*kQu"; */


        $this->conn = new PDO("mysql:host=$server;dbname=$dbname;charset=utf8", $username, $password);

        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->conn->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8'");

        date_default_timezone_set('Asia/Dhaka');
    }

    public function getActiveJob_posts()
    {
        try {


            $stmt = $this->conn->prepare("SELECT `post_id`, `job_id`, `post_title`, `post_category`, `expiration_date`, `designation`, `experience`, `working_hours`, `salary`, `post_date`, `post_month`, `post_year`, `posted_on`, `is_published`, `is_expired`, `created_by`, `created_at`, `updated_at` FROM `job_posts` WHERE is_published = 1");
            $stmt->execute();
            $output = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $output;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function jobPostsDetails_byID($post_id)
    {
        try {
            $stmt = $this->conn->prepare("SELECT *FROM `job_posts` where post_id = ? ");
            $stmt->execute(array($post_id));
            $output = $stmt->fetch(PDO::FETCH_ASSOC);

            return $output;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getQustions_byPostId($post_id)
    {
        try {
            $stmt = $this->conn->prepare("SELECT *FROM `job_questions` WHERE `post_id` = '$post_id'");
            $stmt->execute();
            $output = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $output;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }


    public function saveApplicant_data($data)
    {
        try {

            extract($data);

            $milliseconds        = round(microtime(true) * 1000);
            $application_id      = 'application@' . date('dmY') . ':' . date('hi') . ':' . $milliseconds;
            $applicant_id        = 'applicant@' . date('dmY') . ':' . date('hi') . ':' . $milliseconds;
            $answer_id           = 'answer@' . date('dmY') . ':' . date('hi') . ':' . $milliseconds;
            $file_name           = date('dmY') . date('his') . $milliseconds;
            // image upload

            $target_dir = "upload_files/images/";
            $target_file = $target_dir . $file_name . basename($_FILES["propic"]["name"]);

            // $uploadOk = 1;
            // $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            move_uploaded_file($_FILES["propic"]["tmp_name"], $target_file);
            $image_name = $file_name . basename($_FILES["propic"]["name"]);

            // Check if file already exists
            // if (file_exists($target_file)) {
            //     return "Sorry, file already exists.";
            //     $uploadOk = 0;
            // }

            // Check file size
            // if ($_FILES["propic"]["size"] > 5000000) {
            //     return "Sorry, your file is too large.";
            //     $uploadOk = 0;
            // }

            // Allow certain file formats
            // if (
            //     $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            //     && $imageFileType != "gif"
            // ) {
            //     return "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            //     $uploadOk = 0;
            // }

            // Check if $uploadOk is set to 0 by an error
            // if ($uploadOk == 0) {
            //     return "Sorry, your file was not uploaded.";
            //     // if everything is ok, try to upload file
            // } else {

            //     move_uploaded_file($_FILES["propic"]["tmp_name"], $target_file);
            //     $image_name = basename($_FILES["propic"]["name"]);
            // }

            //NID file upload

            $target_dir = "upload_files/documents/";
            $target_file = $target_dir . $file_name . basename($_FILES["identificationDoc_file"]["name"]);
            // $uploadOk = 1;
            // $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            move_uploaded_file($_FILES["identificationDoc_file"]["tmp_name"], $target_file);
            $identificationDoc_file = $file_name . basename($_FILES["identificationDoc_file"]["name"]);

            // Check if file already exists
            // if (file_exists($target_file)) {
            //     return "Sorry, file already exists.";
            //     $uploadOk = 0;
            // }

            // Check file size
            // if ($_FILES["identificationDoc_file"]["size"] > 5000000) {
            //     return "Sorry, your file is too large.";
            //     $uploadOk = 0;
            // }

            // Allow certain file formats
            // if (
            //     $fileType != "jpg" && $fileType != "png" && $fileType != "jpeg"
            //     && $fileType != "gif" && $fileType != "pdf" && $fileType != "docx"
            // ) {
            //     return "Sorry,these files are allowed.";
            //     $uploadOk = 0;
            // }

            // Check if $uploadOk is set to 0 by an error

            // if ($uploadOk == 0) {
            //     return "Sorry, your file was not uploaded.";
            //     // if everything is ok, try to upload file
            // } else {

            //     move_uploaded_file($_FILES["identificationDoc_file"]["tmp_name"], $target_file);
            //     $identificationDoc_file = basename($_FILES["identificationDoc_file"]["name"]);
            // }

            $stmt = $this->conn->prepare("INSERT INTO `applicants_data`(`application_id`, `applicant_id`, `job_id`, `post_id`, `firstname`, `lastname`, `father_name`, `father_profession`, `mother_name`, `mother_profession`, `phone`, `email`, `emergency_name`,`emergency_contact`, `permanent_address`, `present_address`, `identification_docNo`, `identification_select`, `career_objectives`, `skills`, `propic`,  `identificationDoc_file`, `audio`, `video`, `salary`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->execute(array($application_id, $applicant_id, 123, $post_id, $firstname, $lastname, $father_name, $father_profession, $mother_name, $mother_profession, $phone, $email, $emergency_name, $emergency_contact, $permanent_address, $present_address, $identification_docNo, $identification_select, $career_objectives, $skills, $image_name, $identificationDoc_file, $audio, $video, $salary));


            $stmt = $this->conn->prepare("INSERT INTO `applicants_experiences`(`application_id`, `applicant_id`, `post_id`, `organization`, `position`, `responsibility`, `experience_from`, `experience_to`, `is_working`) VALUES (?,?,?,?,?,?,?,?,?)");


            for ($i = 0; $i < count($organization); $i++) {

                if (!empty($organization[$i])) {
                    $organizationx    = $organization[$i];
                    $positionx        = $position[$i];
                    $responsibilityx  = $responsibility[$i];
                    $experience_fromx = $experience_from[$i];
                    $experience_tox   = $experience_to[$i];

                    if ($is_working[$i] == 1) {
                        $working_status = 1;
                    } else {
                        $working_status = 0;
                    }


                    $stmt->execute(array($application_id, $applicant_id, $post_id, $organizationx, $positionx, $responsibilityx, $experience_fromx, $experience_tox, $working_status));
                }
            }


            $stmt = $this->conn->prepare("INSERT INTO `applicants_educations`(`application_id`, `applicant_id`, `post_id`, `degree`, `institute`, `passing_year`, `cgpa`) VALUES (?,?,?,?,?,?,?)");

            for ($i = 0; $i < count($degree); $i++) {

                if (!empty($degree[$i])) {
                    $degreex       = $degree[$i];
                    $institutex    = $institute[$i];
                    $passing_yearx = $pass_year[$i];
                    $cgpax         = $cgpa[$i];

                    $stmt->execute(array($application_id, $applicant_id, $post_id, $degreex, $institutex, $passing_yearx, $cgpax));
                }
            }


            $stmt = $this->conn->prepare("INSERT INTO `applicants_references`(`application_id`, `applicant_id`, `post_id`, `ref_name`, `ref_organization`, `ref_designation`, `ref_contactNo`) VALUES (?,?,?,?,?,?,?)");
            for ($i = 0; $i < count($ref_name); $i++) {

                if (!empty($ref_name[$i])) {
                    $ref_namex         = $ref_name[$i];
                    $ref_organizationx = $ref_organization[$i];
                    $ref_designationx  = $ref_designation[$i];
                    $ref_contactNox    = $ref_contactNo[$i];

                    $stmt->execute(array($application_id, $applicant_id, $post_id, $ref_namex, $ref_organizationx, $ref_designationx, $ref_contactNox));
                }
            }

            $stmt = $this->conn->prepare("INSERT INTO `applicants_answers`(`application_id`, `applicant_id`, `post_id`, `qus_id`, `ans_id`, `answer`) VALUES (?,?,?,?,?,?)");
            for ($i = 0; $i < count($qus_id); $i++) {
                if (!empty($qus_id[$i])) {
                    $qus_idx   = $qus_id[$i];
                    $answerx   = $answer[$i];
                    $stmt->execute(array($application_id, $applicant_id, $post_id, $qus_idx, $answer_id, $answerx));
                }
            }
            header('Location:confirmation.php');
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getJob_contexts($post_id)
    {
        try {


            $stmt = $this->conn->prepare("SELECT * FROM `job_contexts` WHERE post_id = '$post_id' ");
            $stmt->execute();
            $output = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $output;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getJob_responsibilities($post_id)
    {
        try {


            $stmt = $this->conn->prepare("SELECT * FROM `job_responsibilities` WHERE post_id = '$post_id' ");
            $stmt->execute();
            $output = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $output;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }


    public function getJob_eduRequ($post_id)
    {
        try {


            $stmt = $this->conn->prepare("SELECT * FROM `jobeducational_equirements` WHERE  post_id = '$post_id' ");
            $stmt->execute();
            $output = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $output;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }


    public function getJob_experiences($post_id)
    {
        try {


            $stmt = $this->conn->prepare("SELECT * FROM `job_experiences` WHERE  post_id = '$post_id' ");
            $stmt->execute();
            $output = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $output;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getJob_additionRequires($post_id)
    {
        try {


            $stmt = $this->conn->prepare("SELECT * FROM `job_additionals` WHERE  post_id = '$post_id' ");
            $stmt->execute();
            $output = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $output;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function data_byId($post_id, $column)
    {
        try {


            $stmt = $this->conn->prepare("SELECT $column FROM `job_posts` WHERE post_id = '$post_id' ");
            $stmt->execute();
            $output = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($output as $x) {
                $data = $x[$column];
            }

            if (count($output) == 0) {
                $data = "";
            }

            return $data;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getQuestionsBy_postID($post_id)
    {
        try {


            $stmt = $this->conn->prepare("SELECT *FROM `job_questions` WHERE post_id = '$post_id'");
            $stmt->execute();
            $output = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $output;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getJob_benefits($post_id)
    {
        try {


            $stmt = $this->conn->prepare("SELECT * FROM `job_benefits` WHERE  post_id = '$post_id' ");
            $stmt->execute();
            $output = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $output;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}
