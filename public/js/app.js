//Auto generate password when user click generate password button
const password = document.getElementById("password");

const generatePassword = () => {
    const length = Math.floor(Math.random() * 5) + 4; // Random length between 4 and 8
    const charset =
        "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+~`|}{[]:;?><,./-=";
    let pwd = "";

    // Ensure at least one character from each category
    pwd += getRandomCharacter("abcdefghijklmnopqrstuvwxyz"); // Small letter
    pwd += getRandomCharacter("ABCDEFGHIJKLMNOPQRSTUVWXYZ"); // Capital letter
    pwd += getRandomCharacter("0123456789"); // Number
    pwd += getRandomCharacter("!@#$%^&*()_+~`|}{[]:;?><,./-="); // Special character

    // Generate remaining characters randomly
    for (let i = 4; i < length; i++) {
        let randomIndex = Math.floor(Math.random() * charset.length);
        pwd += charset[randomIndex];
    }

    password.value = pwd;
};

const getRandomCharacter = (charset) => {
    let randomIndex = Math.floor(Math.random() * charset.length);
    return charset[randomIndex];
};

//Change Excel Ui and Normal Ui
const excelRadio = document.getElementById("excelRadio");

const handleUISelection = () => {
    if (excelRadio.checked) {
        window.location.href = "/excel-registrations";
    } else {
        window.location.href = "/show-forms";
    }
};

//Save successful message fade out after 1s
setTimeout(() => {
    $(".hide-message").fadeOut("slow", function () {
        location.reload();
    });
}, 1000);

// Wait for the DOM content to be loaded
document.addEventListener("DOMContentLoaded", () => {
    const removeImageBtn = document.getElementById("removeImage");

    if (removeImageBtn) {
        removeImageBtn.addEventListener("click", () => {
            const imagePreview = document.getElementById("imagePreview");
            const photoInput = document.getElementById("photoInput");

            // Reset the image preview and hide the remove button
            imagePreview.setAttribute("src", "#");
            imagePreview.style.display = "none";
            removeImageBtn.style.display = "none";
            photoInput.value = "";
        });
    }

    const photoInput = document.getElementById("photoInput");

    if (photoInput) {
        photoInput.addEventListener("change", (e) => {
            const input = e.target;
            const imagePreview = document.getElementById("imagePreview");
            const removeImageBtn = document.getElementById("removeImage");
            const photoError = document.getElementById("photoError");

            // Check if a file is selected
            if (input.files && input.files[0]) {
                // Add the source of the image preview and display it
                imagePreview.setAttribute(
                    "src",
                    URL.createObjectURL(input.files[0])
                );
                imagePreview.style.display = "block";
                removeImageBtn.style.display = "block";
                photoError.innerHTML = "";
            }
        });
    }
});

//When user click close icon, close the error message
document.addEventListener("DOMContentLoaded", () => {
    const closeIcons = document.getElementsByClassName("close-icon");
    Array.from(closeIcons).forEach((icon) => {
        icon.addEventListener("click", () => {
            const errorMessageBlock = icon.closest(".alert");
            errorMessageBlock.remove();
        });
    });
});

//When there is no value in search input field, prevent the form submission
const validateForm = (e) => {
    const employeeId = document.getElementById("employee_id").value.trim();
    const employeeCode = document.getElementById("employee_code").value.trim();
    const employeeName = document.getElementById("employee_name").value.trim();
    const emailAddress = document.getElementById("email_address").value.trim();

    if (
        employeeId === "" &&
        employeeCode === "" &&
        employeeName === "" &&
        emailAddress === ""
    ) {
        e.preventDefault(); // Prevent form submission
    }
};

//Go to certain route when user click search/excel download/pdf download button
const searchEmployee = document.getElementById("searchEmployee");
const exportExcel = document.getElementById("exportExcel");
const generatePDF = document.getElementById("generatePDF");
const deleteButton = document.getElementById("deleteButton");
const form = document.getElementById("ListForm");

if (searchEmployee) {
    searchEmployee.addEventListener("click", (e) => {
        validateForm(e); // Validate the form
        if (!e.defaultPrevented) {
            form.action = "/search-employees";
            form.submit();
        }
    });
}

if (exportExcel) {
    exportExcel.addEventListener("click", () => {
        form.action = "/export-search-employees";
        form.submit();
    });
}

if (generatePDF) {
    generatePDF.addEventListener("click", () => {
        form.action = "/pdf-download-employees";
        form.submit();
    });
}