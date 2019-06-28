
<?php if($data['query']): ?>
<div class="alert alert-success" role="alert">
  <strong>Отлично!</strong> Суперпользователь успешно добавлен!
</div>
<?php endif ?>

<?php if($data['query'] === false): ?>
    <div class="alert alert-danger" role="alert">
    <strong>Ошибка!</strong> Будьте внимательны! Возможно такой суперпользователь существует!
    </div>
<?php endif ?>

<div class="d-flex justify-content-center">
<div class="card shadow mb-4 col-sm-6 p-0">
 <div class="card-header py-3">
 <h5 class="m-0 font-weight-bold text-primary d-inline">Добавление суперпользователя</h5></div>

<div class="card-body">

 <form method="post">
  <div class="form-group">
    <label for="name">Логин</label>
    <input type="text" class="form-control" id="name" name="login">
  </div>
  <div class="form-group">
    <label for="position">Пароль</label>
    <input type="text" class="form-control" id="position" name="password">
  </div>
  <button type="submit" class="btn btn-primary">Добавить</button>
</form> 

</div>

</div>
</div>