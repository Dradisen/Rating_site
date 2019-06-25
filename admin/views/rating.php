<div>

<!--<h1 class="h3 mb-4 text-gray-800">Список сотрудников</h1> -->
<!--
<div class="card shadow mb-4">
<div class="card-header py-3">
    <h5 class="m-0 font-weight-bold text-primary d-inline">Рейтинг сотрудников</h5>
    <a class="btn float-right btn-success text-white"
       href="/admin/rating/add">Добавить</a>
</div>

<div class="card-body">

<div class="table-responsive-sm">
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Фамилия имя</th>
      <th scope="col">Месяц</th>
      <th scope="col">Год</th>
      <th scope="col">Рейтинг</th>
      <th scope="col" class="col-sm-3 text-center">Редактировать/Удалить</th>
    </tr>
  </thead>

  <tbody>
    <?php while($row = $data['rating']->fetch()): ?>
    <tr>
      <th scope="row">#</th>
      <td><?=$row['worker']; ?></td>
      <td><?=$data['months'][$row['month']]; ?></td>
      <td><?=$row['year']; ?></td>
      <td><?=$row['rating']; ?></td>
      <td class="text-center">
        <a class="btn btn-warning btn-circle btn-sm" href="#"><i class="fas fa-pencil-alt"></i></a>
        <a class="btn btn-danger btn-circle btn-sm" href=<?="delete?id=".$row['id'];?> ><i class="fas fa-trash"></i></a>
      </td>
    </tr>
    <?php endwhile ?>
  </tbody>
</table>


</div>
</div>
</div>

-->

<div class="card shadow mb-4">
<div class="card-header py-3">
    <h5 class="m-0 font-weight-bold text-primary d-inline">Рейтинг сотрудников</h5>
    <a class="btn float-right btn-success text-white"
       href="/admin/rating/add">Добавить</a>
</div>

<div class="card-body">

<div class="table-responsive-sm">
<table class="table" id="table" v-cloak>
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Фамилия имя</th>
      <th scope="col">Месяц</th>
      <th scope="col">Год</th>
      <th scope="col">Рейтинг</th>
      <th scope="col" class="col-sm-3 text-center">Редактировать/Удалить</th>
    </tr>

    <tr>
      <th scope="col"></th>
      <th scope="col">
        <div class="form-group">
        <input type="text" class="form-control" v-model="name">
        </div>
      </th>
      <th scope="col">
      <div class="form-group">
        <select v-model="month" class="form-control">
          <?php for($i = 0; $i <= 12; $i++): ?>
            <?php if(!$i): ?>
                <option value=<?=$i; ?> >Все месяцы</option>  
            <?php else: ?>
              <option value=<?=$i; ?> ><?=$data['months'][$i]; ?></option>
            <?php endif ?>
          <?php endfor ?>
        </select>
      </div>  
      <th scope="col">
      <div class="form-group">
        <select v-model="year" class="form-control">
          <?php for($i = "20".date('y'); $i >= 2000; $i--): ?>
              <option value=<?=$i; ?> ><?=$i; ?></option> 
          <?php endfor ?>
        </select>
      </div>
      <th scope="col"></th>
      <th scope="col"></th>
    </tr>

  </thead>

  <tbody>
    <tr v-for="(todo, index) in filtered">
      <th scope="row">{{index+1}}</th>
      <td>{{todo.worker}}</td>
      <td>{{month_verbal[todo.month]}}</td>
      <td>{{todo.year}}</td>
      <td>{{todo.rating}}</td>
      <td class="text-center">
        <a class="btn btn-warning btn-circle btn-sm" 
           :href="'/admin/rating/edit/'+todo.id" ><i class="fas fa-pencil-alt"></i></a>
        <a class="btn btn-danger btn-circle btn-sm" 
           :href="'/admin/rating/delete/'+todo.id" ><i class="fas fa-trash"></i></a>
      </td>
    </tr>
  </tbody>
</table>


</div>
</div>
</div>



</div>


