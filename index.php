<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajax</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<style>
    .user-img {
        width: 70px;
        height: 70px;
    }

    /* The switch - the box around the slider */
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    /* Hide default HTML checkbox */
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    /* The slider */
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #2196F3;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }

    .profile_icon {
        cursor: pointer;
    }

    #clos_btn {
        top: 10px;
        right: 10px;
        font-size: 22px;
        display: none;
    }
    #edit_clos_btn{
        top: 10px;
        right: 10px;
        font-size: 22px;
        display: none;
    }
</style>

<body>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12 my-5">
                    <button data-bs-toggle="modal" data-bs-target="#creat_students" class=" btn btn-sm btn-primary">Creat New Studens</button>
                    <br>
                    <br>
                    <div class="card">
                        <div class="card-header">
                            <h2>All Studens</h2>
                        </div>
                        <div class="card-body">
                            <table class=" table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Age</th>
                                        <th>Location</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="user_data">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="creat_students" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between">
                    <h5 class="modal-title" id="my-modal-title">Creat a New Studen</h5>
                    <button class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="creat_studen_form" method="POST" enctype="multipart/form-data">
                        <div class="my-2">
                            <label for="">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter Your Name">
                        </div>
                        <div class="my-2">
                            <label for="">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter Your Email">
                        </div>
                        <div class="my-2">
                            <label for="">Age</label>
                            <input type="text" name="age" class="form-control" placeholder="Enter Your Age">
                        </div>
                        <div class="my-2">
                            <label for="">Location</label>
                            <input type="text" name="location" class="form-control" placeholder="Enter Your Location">
                        </div>
                        <div class="my-2">
                            <label for="">Photo</label>
                            <label>
                                <input id="profil_input" type="file" name="photo" class="form-control d-none">
                                <img id="profile_icon" class=" w-100 profile_icon h-auto object-fit-cover" src="https://www.lifewire.com/thmb/TRGYpWa4KzxUt1Fkgr3FqjOd6VQ=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/cloud-upload-a30f385a928e44e199a62210d578375a.jpg" alt="">
                            </label>
                            <div class="priv_img position-relative">
                                <img class=" w-100" id="priv_img" src="" alt="">
                                <button id="clos_btn" class=" position-absolute border-0 text-danger bg-transparent" type="button"><i class="fa-solid fa-xmark"></i></button>
                            </div>
                        </div>
                        <div class="my-2">
                            <input type="submit" value="Submit" class="btn btn-primary w-100">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="update_students_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between">
                    <h5 class="modal-title" id="my-modal-title">Update Student Data</h5>
                    <button class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form id="edit_studen_form" method="POST" enctype="multipart/form-data">
                        <div class="my-2">
                            <label for="">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter Your Name">
                        </div>
                        <input type="hidden" class="form-control" name="edit_id">
                        <input type="hidden" class="form-control" name="photo_url">
                        <div class="my-2">
                            <label for="">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter Your Email">
                        </div>
                        <div class="my-2">
                            <label for="">Age</label>
                            <input type="text" name="age" class="form-control" placeholder="Enter Your Age">
                        </div>
                        <div class="my-2">
                            <label for="">Location</label>
                            <input type="text" name="location" class="form-control" placeholder="Enter Your Location">
                        </div>
                        <img class="edit_prv_img w-100" src="" alt="">
                        <div class="my-2">
                            <label for="">Photo</label>
                            <label>
                                <input id="edit_profil_input" type="file" name="new_photo" class="form-control d-none">
                                <img id="edit_profile_icon" class=" w-100 profile_icon h-auto object-fit-cover" src="https://www.lifewire.com/thmb/TRGYpWa4KzxUt1Fkgr3FqjOd6VQ=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/cloud-upload-a30f385a928e44e199a62210d578375a.jpg" alt="">
                            </label>
                            <div class="priv_img position-relative">
                                <img class=" w-100" id="edit_priv_img" src="" alt="">
                                <button id="edit_clos_btn" class=" position-absolute border-0 text-danger bg-transparent" type="button"><i class="fa-solid fa-xmark"></i></button>
                            </div>
                        </div>
                        <div class="my-2">
                            <input type="submit" value="Submit" class="btn btn-primary w-100">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="Single_students_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between">
                    <h5 class="modal-title" id="my-modal-title">Single Studens</h5>
                    <button class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="view_students_info">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./js/ajax.js"></script>
    <script>
        $(document).ready(function() {
            // $.ajax({
            //     url: "./ajax/ajax_templat.php?action=student_creat",
            //     contentType: false,
            //     processData: false


            // })
        });
    </script>
</body>

</html>