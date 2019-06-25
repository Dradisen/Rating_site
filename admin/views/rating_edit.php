<?php if(isset($data['query'])): ?>

    <?php if($data['query']): ?>
    <div class="alert alert-success" role="alert">
    <strong>Отлично!</strong> Рейтинг успешно изменён!
    </div>
    <?php endif ?>

    <?php if($data['query'] === false): ?>
        <div class="alert alert-danger" role="alert">
        <strong>Ошибка!</strong> Будьте внимательны! Рейтинг сотрудника уже существует!
        </div>
    <?php endif ?>

<?php endif ?>

<?php if(isset($data['query_1'])): ?>

    <?php if($data['query_1'] === false): ?>
        <div class="alert alert-danger" role="alert">
        <strong>Ошибка!</strong> Будьте внимательны! Вы пытались перенести сотрудника на месяц,
            в котором он уже существует!
        </div>
    <?php endif ?>

<?php endif ?>

<div class="d-flex justify-content-center">
<div class="card shadow mb-4 col-sm-6 p-0">
 <div class="card-header py-3">
 <h5 class="m-0 font-weight-bold text-primary d-inline">Изменение рейтинга</h5></div>

<div class="card-body">


<form @submit='checkForm' method="post" id="form" v-cloak>
    <?php $row = $data['rating']->fetch(); ?>
    <p v-if="errors.length">
    <b>Исправьте ошибки:</b>
        <ul>
        <li class="alert alert-danger p-1" v-for="error in errors">{{ error }}</li>
        </ul>
    </p>

    <div class='form-group'>
    <label for="date_month">Месяц</label>
        <select class='form-control' name='date_month'>   
            <?php $month = (int)date('m'); $year = (int)"20".date('y');?>

            <?php for($i = 1; $i <= 12; $i++): ?>
                <?php if($i==$row['month']): ?>
                    <option value=<?=$i ?> selected><?=$data['months'][$i]; ?></option>
                <?php else: ?>
                    <option value=<?=$i ?> ><?=$data['months'][$i]; ?></option>";
                <?php endif ?>
            <?php endfor ?>
        </select>
    </div>

    <div class='form-group'>
    <label for="date_month">Год</label>
        <select class='form-control' name='date_year' default='2019'>
            <?php for($i = $year; $i >= 2000; $i--): ?>
                <?php if($i == $row['year']): ?>
                    <option selected value=<?=$i; ?> ><?=$i; ?></option>
                <?php else: ?>
                    <option value=<?=$i; ?> ><?=$i; ?></option>
                <?php endif ?>
            <?php endfor ?>
        </select>
    </div>

    <div class="form-group">
    <label for="position">Рейтинг</label>
        <input type="number" class="form-control" id="rating" name='rating' v-model='message'
                value=<?php echo "'".$row['rating']."'" ?> >
    </div>

    <label for="name">Сотрудник</label>

    <div class='form-group'>
    <select class='form-control' name='worker_id' >
        <option value=<?=$row['id']; ?> ><?=$row['worker']; ?></option>
    </select>
    </div>
    

    <button type="submit" class="btn btn-primary">Изменить</button>
</form>

</div>
</div>
</div>