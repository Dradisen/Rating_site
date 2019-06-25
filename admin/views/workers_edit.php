<?php $row = $data['worker']->fetch(); ?>
<div class="d-flex justify-content-center">
<div class="card shadow mb-4 col-sm-6 p-0">
 <div class="card-header py-3">
 <h5 class="m-0 font-weight-bold text-primary d-inline">Изменение</h5></div>

<div class="card-body">

 <form @submit='checkForm' method="post" id="form">
  <div v-if="errors.length" v-cloak>
      <p>error</p>
  </div>
  <div class="form-group">
    <label for="name">Фамилия Имя</label>
    <input type="text" class="form-control" id="name" name="name" v-model="name"
           value=<?php echo "'".$row['worker']."'" ?> >
  </div>
  <div class="form-group">
    <label for="position">Должность</label>
    <input type="text" class="form-control" id="position" name="position" v-model="position"
           value=<?php echo "'".$row['position']."'" ?>>
  </div>
  <button type="submit" class="btn btn-primary">Изменить</button>
</form> 

</div>

</div>
</div>