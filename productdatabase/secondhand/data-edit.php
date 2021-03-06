<?php
$page_title = '編輯資料';
$page_name = 'data-edit';
require __DIR__ . '/../parts/__connect_db.php';
require __DIR__ . '/../parts/__admin-required.php';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if (empty($sid)) {
    header('Location: data-list.php');
    exit;
}

$sql = " SELECT * FROM i_secondhand_product WHERE sid=$sid";
$rows = $pdo->query($sql)->fetch();
if (empty($rows)) {
    header('Location: data-list.php');
    exit;
}


?>
<?php
$row = $pdo->query("SELECT * FROM `i_secondhand_product` ")->fetch();

$c_sql = "SELECT * FROM i_secondhand_conditions ORDER BY sid ASC";
$cates = $pdo->query($c_sql)->fetchAll();

$h_sql = "SELECT * FROM i_secondhand_framework ORDER BY sid ASC";
$framework = $pdo->query($h_sql)->fetchAll();

$v_sql = "SELECT * FROM i_secondhand_material ORDER BY sid ASC";
$material = $pdo->query($v_sql)->fetchAll();

$g_sql = "SELECT * FROM i_secondhand_categories ORDER BY sid ASC";
$categories = $pdo->query($g_sql)->fetchAll();
?>
<?php require __DIR__ . '/../parts/__html_head.php'; ?>
<style>
    span.red-stars {
        color: red;
    }

    small.error-msg {
        color: red;
    }

    body {
        background-color: #EFF0F0;
    }


    .form-group button {
        width: 540px;
        height: 45px;

    }

    .button {
        width: 540px;
        height: 45px;
        color: white;
    }

    .redstars {
        color: red;
    }

    #infobar {
        margin: auto
    }

    h3 {
        margin: 30px auto;
    }

    .breadcrumb {
        background-color: #EFF0F0;
    }

    .breadcrumb .breadcrumb-item.active {
        color: #C77334;
    }
</style>
</style>
<?php include __DIR__ . '/../parts/__navbar.php'; ?>
<div class="container">
    <ol class="breadcrumb ">
        <li class="breadcrumb-item "><a class="text-black-50" href="#">後台管理</a></li>
        <li class="breadcrumb-item "><a class="text-black-50" href="#">二手管理</a></li>
        <li class="breadcrumb-item "><a class="text-black-50" href="data-list.php">二手商品列表</a></li>
        <li class="breadcrumb-item active" aria-current="page">編輯二手商品</li>
    </ol>
    <h3 class="d-flex justify-content-center">編輯二手商品</h3>


    <div id="infobar" class="alert alert-success" role="alert" style="display: none">
        A simple success alert—check it out!
    </div>



    <form class="row" name="form1" onsubmit="checkForm(); return false;" novalidate>
        <div class="col">
            <input type="hidden" name="sid" value="<?= $rows['sid'] ?>">
            <div class="form-group">
                <label for="product_no"><span class="red-stars">**</span> 商品編號</label>
                <input type="text" class="form-control" id="product_no" name="product_no" required value="<?= htmlentities($rows['product_no']) ?>">
                <small class="form-text error-msg"></small>
            </div>
            <div class="form-group">
                <label for="productname"><span class="red-stars">**</span> 商品名稱</label>
                <input type="text" class="form-control" id="productname" name="productname" required value="<?= htmlentities($rows['productname']) ?>">
                <small class="form-text error-msg"></small>
            </div>

            <div class="form-group">
                <label for="price"><span class="red-stars">**</span> 價錢</label>
                <input type="text" class="form-control" id="price" name="price" required value="<?= htmlentities($rows['price']) ?>">
                <small class="form-text error-msg"></small>
            </div>
            <div class="form-group">
                <label for="stock"><span class="red-stars">**</span> stock</label>
                <input type="text" class="form-control" id="stock" name="stock" required value="<?= htmlentities($rows['stock']) ?>">
                <small class="form-text error-msg"></small>
            </div>
            <div class="form-group">
                <label for="description">商品描述</label>
                <textarea class="form-control" name="description" id="description" cols="30" rows="3"><?= htmlentities($rows['description']) ?></textarea>
            </div>
        </div>
        <div class="col">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="photo"></span>photo</label><br>
                    <button type="button" class="btn btn-secondary mb-3" onclick="file_input.click()">修改圖片</button>
                    <input type="hidden" id="avatar" name="photo" value="<?= $rows['photo'] ?>">
                    <img src="./../uploads/<?= $rows['photo'] ?>" alt="" id="myimg" width="250px">
                </div>

                <input type="file" id="file_input" style="display: none">



                <div class="form-group">
                    <label for="conditions_sid">商品狀況</label><br>
                    <?php foreach ($cates as $key => $c) : ?>
                        <div class="form-check form-check-inline ">
                            <input class="form-check-input " type="radio" name="conditions_sid" id="conditions_sid<?= $c['sid'] ?>" value="<?= $c['sid'] ?>" <?= ($rows['conditions_sid'] == $key + 1) ? 'checked' : '' ?>>

                            <label class="form-check-label " for="conditions_sid<?= $c['sid'] ?>"><?= $c['name'] ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="form-group">
                    <label for="framework_sid">骨架</label><br>
                    <?php foreach ($framework as $key => $b) : ?>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="framework_sid" value="<?= htmlentities($rows['framework_sid']) ?>" id="framework_sid<?= $b['sid'] ?>" value="<?= $b['sid'] ?>" <?= ($rows['framework_sid'] == $key + 1) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="framework_sid<?= $b['sid'] ?>"><?= $b['name'] ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="form-group">
                    <label for="material_sid">材質</label><br>
                    <?php foreach ($material as $key => $m) : ?>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="material_sid" value="<?= htmlentities($rows['material_sid']) ?>" id="material_sid<?= $m['sid'] ?>" value="<?= $m['sid'] ?>" <?= ($rows['framework_sid'] == $key + 1) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="material_sid<?= $m['sid'] ?>"><?= $m['name'] ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="form-group">
                    <label for="categories_sid">分類</label>
                    <select class="form-control" id="categories_sid" name="categories_sid" value="<?= htmlentities($rows['categories_sid']) ?>">

                        <?php foreach ($categories as $key => $s) : ?>


                            <option value="<?= $s['sid'] ?>" <?= ($rows['categories_sid'] == $key + 1) ? 'selected' : '' ?>>
                                <?= $s['name'] ?>
                            </option>


                        <?php endforeach; ?>
                    </select>
                </div>


                <button type="submit" class="button btn btn-warning">修改完成</button>
            </div>
        </div>

    </form>











</div>
<?php include __DIR__ . '/../parts/__scripts.php'; ?>
<script>
    // const email_pattern = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    // const mobile_pattern = /^09\d{2}-?\d{3}-?\d{3}$/;
    // const $name = document.querySelector('#name');
    // const $email = document.querySelector('#email');
    const $product_no = document.querySelector('#product_no');
    const product_no_pattern = /^ch\d{3}$/;
    // const $mobile = document.querySelector('#mobile');
    const r_fields = [$product_no];
    const infobar = document.querySelector('#infobar');
    const submitBtn = document.querySelector('button[type=submit]');

    function checkForm() {
        let isPass = true;

        r_fields.forEach(el => {
            el.style.borderColor = '#CCCCCC';
            el.nextElementSibling.innerHTML = '';
        });
        submitBtn.style.display = 'none';
        // // TODO: 檢查資料格式
        // if ($name.value.length < 2) {
        //     isPass = false;
        //     $name.style.borderColor = 'red';
        //     $name.nextElementSibling.innerHTML = '請填寫正確的姓名';
        // }

        if (!product_no_pattern.test($product_no.value)) {
            isPass = false;
            $product_no.style.borderColor = 'red';
            $product_no.nextElementSibling.innerHTML = '請填寫正確商品編號';
        }

        // if (!mobile_pattern.test($mobile.value)) {
        //     isPass = false;
        //     $mobile.style.borderColor = 'red';
        //     $mobile.nextElementSibling.innerHTML = '請填寫正確的手機號碼';
        // }

        if (isPass) {
            const fd = new FormData(document.form1);
            console.log('pass');
            fetch('data-edit-api.php', {
                    method: 'POST',
                    body: fd
                })
                .then(r => r.json())
                .then(obj => {
                    console.log('obj', obj);
                    console.log('obj.success', obj.success);
                    if (obj.success) {
                        console.log('成功');
                        infobar.innerHTML = '修改成功';
                        infobar.className = "alert alert-success";

                        setTimeout(() => {
                            location.href = 'data-list.php';
                        }, 2000)
                    } else {
                        console.log('失敗');
                        infobar.innerHTML = obj.error || '未修改';
                        infobar.className = "alert alert-danger";

                        submitBtn.style.display = 'block';
                    }
                    infobar.style.display = 'block';
                });
        } else {
            console.log('其他');
            submitBtn.style.display = 'block';
        }
    };

    const file_input = document.querySelector('#file_input');
    const avatar = document.querySelector('#avatar');

    file_input.addEventListener('change', function(event) {
        console.log(file_input.files)
        const fd = new FormData();
        fd.append('myfile', file_input.files[0]);

        fetch('upload-single-api.php', {
                method: 'POST',
                body: fd
            })
            .then(r => r.json())
            .then(obj => {
                avatar.value = obj.filename;
                document.querySelector('#myimg').src = './../uploads/' + obj.filename;
            });
    });
</script>
<?php include __DIR__ . '/../parts/__html_foot.php'; ?>