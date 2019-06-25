<div>
<?php if($row=$data['ratings']->count()): ?>

<?php $row = $data['ratings']->fetch(); ?>

    <h3 class="ml-2 mt-2 mb-4 font-weight-bold">
      Рейтинг за <?=$data['months'][$row['month']]." ".$row['year']; ?> года</h3>
<?php endif ?>

<div class="row">

<?php while($row = $data['places']->fetch()): ?>
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="h5 mb-0 font-weight-bold text-gray-800">
                <?=$row['place']." Место" ?>
            </div>
            <div>
              <?php for($i = 0; $i < count($row['names']); $i++): ?>
                <?=$row['names'][$i]?>
              <?php endfor ?>
            </div>
          </div>
          <div class="col-auto">
          <svg width = 60 height = 60>
                <circle cx=30 cy=30 r=30 style="fill:#ffba57;"></circle>
                <text class="h5 mb-0 font-weight-bold text-gray-800"
                       text-anchor="middle" x=50% y=60%
                       style="font-size: 20px; color: white;">
                <?=$row['rating'] ?>
                </text>
              </svg>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php endwhile ?>
  
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
      <div class="card-body">

      <div class="row no-gutters align-items-center">
        <div class="col mr-2 text-center">
          <div class="h6 mb-0 font-weight-bold text-gray-800">
                Средний рейтинг
          </div>
          <div class="h5 mb-0 font-weight-bold text-gray-800">
            <?=$data['avg'] ?>
          </div>
        </div>
        <div class="col-auto">
            <i class="fas fa-chart-area fa-2x text-gray-300"></i>
        </div>

      </div>
      </div>
    </div>
  </div>


</div>

<!--<h1 class="h3 mb-4 text-gray-800">Список сотрудников</h1> -->

<div class="card shadow mb-4">
<div class="card-header py-3">
    <h5 class="m-0 font-weight-bold text-primary d-inline">Список сотрудников</h5>
    <a class="btn float-right btn-success text-white"
       href="/admin/workers/add">Добавить</a>
</div>
<div class="card-body">

<div class="table-responsive-sm">
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Фамилия имя</th>
      <th scope="col">Должность</th>
      <th scope="col" class="text-center">Редактировать/Удалить</th>
    </tr>
  </thead>

  <tbody>
    <?php $i = 1;?>
    <?php while($row = $data['workers']->fetch()): ?>
    <tr>
      <th scope="row"><?=$i++; ?></th>
      <td><?=$row['worker']; ?></td>
      <td><?=$row['position']; ?></td>
      <td class="text-center">
        <a class="btn btn-warning btn-circle btn-sm" 
           href=<?="/admin/workers/edit/".$row['id'];?>>
          <i class="fas fa-pencil-alt"></i>
        </a>
        <a class="btn btn-danger btn-circle btn-sm qmodal" 
           data-toggle="modal" 
           data-target="#deleteModal"
           href=<?=$url="/admin/workers/delete/".$row['id'];?> ><i class="fas fa-trash"></i></a>
      </td>
    </tr>
    <?php endwhile ?>
  </tbody>
</table>
</div>
</div>
</div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" 
      aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Удаление</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Вы точно хотите удалить сотрудника?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
        <a id="href" class="btn btn-primary" href="" >Удалить</a>
      </div>
    </div>
  </div>
</div>