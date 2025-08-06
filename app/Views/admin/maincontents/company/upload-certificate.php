<?php
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];
$userType           = $session->user_type;
?>
<div class="container-fluid">
    <div class="pagetitle">
        <h1><?= $page_header ?></h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Home</a></li>
                <li class="breadcrumb-item active"><a href="<?= base_url('admin/' . $controller_route . '/list/') ?>"><?= $title ?> List</a></li>
                <li class="breadcrumb-item active"><?= $page_header ?></li>
            </ol>
        </nav>
    </div>
</div>

<section class="section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <!-- <form id="uploadForm" enctype="multipart/form-data">
                            <input type="hidden" name="company_id" value="<?=$company_id?>"> -->
                            <div class="container py-4">
                                <h5 class="card-titles mb-3">
                                    <strong><?=$company_name?></strong>
                                </h5>
                                <!-- Upload UI -->
                                <div class="upload-box mb-4" onclick="document.getElementById('fileInput').click()">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" fill="currentColor" class="mb-2" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 0a5.53 5.53 0 0 0-5.468 4.5 3.5 3.5 0 1 0 .934 6.94h3.188v-3H5.5a.5.5 0 0 1 0-1h2.5V6.207l-.646.647a.5.5 0 0 1-.708-.708l1.5-1.5a.5.5 0 0 1 .708 0l1.5 1.5a.5.5 0 0 1-.708.708L8.5 6.207V8.5h2.5a.5.5 0 0 1 0 1H8.5v3h3.068a3.5 3.5 0 1 0 .933-6.94A5.53 5.53 0 0 0 8 0Z" />
                                    </svg>
                                    <div class="fw-medium">Choose a file or drag & drop it here</div>
                                    <div class="text-muted small mb-3">Only Zip file</div>
                                    <button class="btn btn-outline-secondary rounded-pill">Browse File</button>
                                    <input type="file" id="fileInput" name="certificate_file" class="d-none" multiple>
                                </div>
                                <div id="uploadErrorList"></div>
                                <!-- Uploaded files will appear here -->
                                <div id="uploadList"></div>

                            </div>
                        <!-- </form> -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Sales -->
    <!-- End Recent Sales -->
</section>
<script>
    const fileInput = document.getElementById('fileInput');
    const uploadList = document.getElementById('uploadList');
    const uploadErrorList = document.getElementById('uploadErrorList');

    fileInput.addEventListener('change', function() {
        for (let file of this.files) {
            uploadFile(file);
        }
    });

    function getFileLabel(ext) {
        ext = ext.toLowerCase();
        const labelMap = {
            pdf: {
                text: 'PDF',
                color: '#e63946'
            },
            // zip: {
            //     text: 'ZIP',
            //     color: '#6c757d'
            // },
            // jpg: {
            //     text: 'JPG',
            //     color: '#0d6efd'
            // },
            // jpeg: {
            //     text: 'JPG',
            //     color: '#0d6efd'
            // },
            // png: {
            //     text: 'PNG',
            //     color: '#0d6efd'
            // },
            // doc: {
            //     text: 'DOC',
            //     color: '#198754'
            // },
            // docx: {
            //     text: 'DOCX',
            //     color: '#198754'
            // },
            // default: {
            //     text: ext,
            //     color: '#6c757d'
            // }
        };
        return labelMap[ext] || labelMap['default'];
    }

    function uploadFile(file) {
        console.log(file);
        const formData = new FormData();
        formData.append("certificate_file", file);
        formData.append("company_id", <?=$company_id?>); // Replace with dynamic company_id if needed

        fetch("<?= base_url('admin/companies/certificate/upload') ?>", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                document.getElementById("response").innerText = "Upload successful: " + data.file;
            } else {
                document.getElementById("response").innerText = "Upload failed: " + data.message;
            }
        })
        .catch(error => {
            document.getElementById("response").innerText = "Error: " + error.message;
        });


        const card = document.createElement('div');
        card.className = 'file-card';
        const fileId = 'file-' + Math.random().toString(36).substr(2, 9);

        const ext = file.name.split('.').pop();
        const fileType = getFileLabel(ext);

        card.innerHTML = `
                        <div class="file-left">
                            <div class="file-label" style="background-color: ${fileType.color};">${fileType.text}</div>
                            <div class="w-100">
                            <div class="fw-medium">${file.name}</div>
                            <div class="text-muted text-smaller" id="${fileId}-status">0 KB of ${Math.round(file.size / 1024)} KB • Uploading...</div>
                            <div class="progress-container">
                                <div class="progress w-100">
                                <div class="progress-bar bg-primary" id="${fileId}-bar" style="width: 0%"></div>
                                </div>
                            </div>
                            </div>
                        </div>
                        <button class="btn btn-sm btn-light border-0" onclick="removeCard(this)">✖</button>
                        `;

        // Simulated upload
        let uploaded = 0;
        const total = file.size / 1024;
        if(total < 50){
            uploadList.appendChild(card);
            uploadErrorList.innerText = '';
            const interval = setInterval(() => {
                uploaded += total / 20;
                if (uploaded >= total) {
                    uploaded = total;
                    clearInterval(interval);
                    document.getElementById(`${fileId}-status`).innerHTML =
                        `${Math.round(total)} KB of ${Math.round(total)} KB • <span class="text-success">✔ Completed</span>`;
                } else {
                    document.getElementById(`${fileId}-status`).textContent =
                        `${Math.round(uploaded)} KB of ${Math.round(total)} KB • Uploading...`;
                }
                document.getElementById(`${fileId}-bar`).style.width = `${(uploaded / total) * 100}%`;
            }, 200);
        } else {
            uploadErrorList.innerText = 'Maximum uppload size will be 50 KB';
            return false;
        }
    }

    function removeCard(btn) {
        btn.closest('.file-card').remove();
    }
</script>
<style>
    .upload-box {
        border: 2px dashed #ccc;
        border-radius: 12px;
        padding: 40px 20px;
        text-align: center;
        background-color: #f9f9f9;
        cursor: pointer;
    }

    .upload-box:hover {
        background-color: #f1f1f1;
    }

    .file-card {
        background-color: #f1f5fb;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .file-label {
        color: #fff;
        padding: 5px;
        font-size: 12px;
        border-radius: 4px;
        line-height: 1.25;
        font-weight: 600;
    }

    .file-left {
        display: flex;
        align-items: center;
        gap: 10px;
        width: 90%;
    }

    .pdf-icon {
        background-color: #e63946;
        color: white;
        font-weight: bold;
        font-size: 12px;
        padding: 4px 6px;
        border-radius: 4px;
    }

    .progress {
        height: 6px;
    }

    .progress-bar {
        background-color: #022b6d !important;
    }

    .progress-container {
        margin-top: 5px;
    }

    .text-small {
        font-size: 13px;
    }

    .text-smaller {
        font-size: 12px;
    }
</style>