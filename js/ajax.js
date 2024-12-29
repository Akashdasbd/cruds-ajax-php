$(document).ready(function() {

    // Get All Student Data 
    function getAllStudent(){
    $.ajax({
        url:"./ajax/ajax_templat.php?action=all_student",
        success:function(data){
            const allData =  JSON.parse(data);
            allData.reverse()
            let crunt = 1;
            const tabel_user_data = document.getElementById("user_data");
            let allStundt ="";
                allData.map(element => {
                    allStundt+=`
                                        <tr class=" align-middle">
                                            <td>${crunt++}</td>
                                            <td><img class="user-img img-fluid rounded-pill object-fit-cover" src="media/students/${element.photo}"></td>
                                            <td>${element.name}</td>
                                            <td>${element.age}</td>
                                            <td>${element.location}</td>
                                            <td>${element.email}</td>
                                            <td>
                                                <!-- Rounded switch -->
                                                <label class="switch status_switch" status_id="${element.id}" status="${element.status}">
                                                    <input type="checkbox" ${element.status && "checked"}>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-success edit_btn" edit_id="${element.id}" data-bs-toggle="modal" data-bs-target="#update_students_modal"><i class="fa-solid fa-pen-to-square"></i></button>
                                                <button view_id="${element.id}" data-bs-toggle="modal" data-bs-target="#Single_students_modal" class="btn btn-sm btn-info view_btn"><i class="fa-solid fa-eye"></i></button>
                                                <button delet_img="${element.photo}" delet_id="${element.id}" class="btn btn-sm btn-danger delet_btn"><i class="fa-solid fa-trash"></i></button>
                                            </td>
                                        </tr>
                    `
                });
                tabel_user_data.innerHTML=allStundt;
        }
    })
    }
    getAllStudent();

    $("#creat_studen_form").submit(function(e){
        e.preventDefault();

        const formData =  new FormData(e.target);
        const {name, email, age, location} = Object.fromEntries(formData);
        if(!name || !email || !age || !location) {
            Swal.fire("Alll fields are  requred!");
        }else{
            $.ajax({
                url: "./ajax/ajax_templat.php?action=student_creat",
                method: "POST",
                data: formData ,
                contentType: false,
                processData: false,
                success: function(data){
                    Swal.fire({
                        position: "center", 
                        icon: "success",
                        title: `Created Successfully`,
                        showConfirmButton: false,
                        timer: 1500
                      });
                      e.target.reset();
                      const modalClose = setInterval(() => {
                        $('.close').click();
                        getAllStudent();
                        clearInterval(modalClose);
                      }, 3000);
                      get_all_student();
                },
                error: function(err){
                    console.log(err);
                }
            })
        }
    })


    // status change

    $(document).on("click",".status_switch",function(){
        const status_id = $(this).attr("status_id");
        const status = $(this).attr("status");
        $.ajax({
            url: "./ajax/ajax_templat.php?action=status_change",
            method: "POST",
            data: {status_id, status},
            success : function(data){
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: `${data} Status Change Successfully`,
                    showConfirmButton: false,
                    timer: 1500
                  });
                  getAllStudent();
            }
        })
    })

    // students update
    $(document).on("click",".edit_btn",function(){
        const edit_id = $(this).attr("edit_id");
        $.ajax({
            url: "./ajax/ajax_templat.php?action=student_update",
            method: "POST",
            data: {edit_id},
            success : function(data){
                const student = JSON.parse(data);
                $("#edit_studen_form  input[name='name']").val(student.name);         
                $("#edit_studen_form  input[name='email']").val(student.email);         
                $("#edit_studen_form  input[name='age']").val(student.age);        
                $("#edit_studen_form  input[name='location']").val(student.location);       
                $("#edit_studen_form  input[name='edit_id']").val(student.id);
                $("#edit_studen_form  input[name='photo_url']").val(student.photo);
                document.querySelector(".edit_prv_img").setAttribute("src", `media/students/${student.photo}`);
            }
        })
    })
    // update student
    $("#edit_studen_form").submit(function(e){
        e.preventDefault();
        const formData = new FormData(e.target);
        $.ajax({
            url: "./ajax/ajax_templat.php?action=student_update_submit",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,

            success : function(data){
                Swal.fire({
                    position: "center", 
                    icon: "success",
                    title: `Studnet Update Successfully`,
                    showConfirmButton: false,
                    timer: 1500
                  });
                  e.target.reset();
                  const modalClose = setInterval(() => {
                    $('.close').click();
                    getAllStudent();
                    clearInterval(modalClose);
                  }, 3000);
                  get_all_student();
            },
            error: function(err){
                console.log(err);
            }
        })
    })

    $(document).on("click",".delet_btn",function(){
        const delet_id = $(this).attr("delet_id");
        const delet_img = $(this).attr("delet_img");
        
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "./ajax/ajax_templat.php?action=student_delete",
                    method: "POST",
                    data: {delet_id, delet_img},
                    success: function(data){
                        Swal.fire({
                            title: "Deleted!",
                            text: "Your file has been deleted.",
                            icon: "success"
                          });
                          getAllStudent();
                    }
                })

            }
          });
    })

    $(document).on("click",".view_btn",function(){
        const view_id = $(this).attr("view_id");
        $.ajax({
            url: "./ajax/ajax_templat.php?action=student_view",
            method: "POST",
            data: {view_id},
            success : function(data){
                const student = JSON.parse(data);
                $("#view_students_info").html(`
                         <div class="profile_img w-100">
                            <img class="w-100" src="media/students/${student.photo}" alt="">
                        </div>
                        <div class="students_info">
                            <h3>Name:${student.name}</h3>
                            <h3>Email:${student.email}</h3>
                            <h3>Location:${student.location}</h3>
                            <h3>Age:${student.age}</h3>
                        </div>
                    `);

            }
        })
    })
}
)




const profil_input = document.getElementById("profil_input");
const priv_img = document.getElementById("priv_img")
const profile_icon = document.getElementById("profile_icon")
const clos_btn = document.getElementById("clos_btn")
const edit_profil_input =document.getElementById("edit_profil_input")
const edit_priv_img = document.getElementById("edit_priv_img")
const edit_profile_icon = document.getElementById("edit_profile_icon")
const edit_clos_btn = document.getElementById("edit_clos_btn")
const edit_prv_img = document.querySelector(".edit_prv_img");


profil_input.onchange = function(e){
    const imgUrl = URL.createObjectURL(e.target.files[0]);
    priv_img.setAttribute("src", imgUrl);
    profile_icon.style.display = "none";
    clos_btn.style.display = "block";
    
}
        clos_btn.onclick = (e) => {
            priv_img.setAttribute("src", "");
            profile_icon.style.display = "block"
            clos_btn.style.display = "none"
        }


edit_profil_input.onchange=function(e){
    const imgUrl = URL.createObjectURL(e.target.files[0]);
    edit_priv_img.setAttribute("src", imgUrl);
    edit_profile_icon.style.display = "none";
    edit_clos_btn.style.display = "block";
    edit_prv_img.style.display = "none";
}

edit_clos_btn.onclick=(e)=>{
    edit_priv_img.setAttribute("src", "");
    edit_profile_icon.style.display = "block"
    edit_clos_btn.style.display = "none"
    edit_prv_img.style.display = "block";
}