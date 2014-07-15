<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Bania</title>
    <meta name="generator" content="Bootply" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <?php echo $this->Html->css('bootstrap.css'); ?>
    <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <?php echo $this->Html->css('style_index.css'); ?>
 
<!-- エラー通知 -->
<?php echo $this->Session->flash(); ?>
  
<div class="container">
  <div class="jumbotron text-center">
    <h1>Bania</h1>
    <p class="lead">１次会が終わってさあ2次会。でも予約をしていないあなたに。</p>

        <a href=<?php echo $this->Html->url('/places/index'); ?>><button type="button" class="btn btn-lg btn-primary">現在地を更新する</button></a>

        <?php echo $this->Form->create
          (
          'Place',
          array(
                'type' => 'post', 
                'action'=>'search', 
                'role' => 'form',
                'class' => 'form-inline text-center'
                )
          );
        ?>
        <?php echo $this->Form->submit
            ('順番を並べかえる', 
            array(
              'class' => 'btn btn-lg btn-default',
              'style'=>'margin-top:20px; margin-bottom:20px;'
              )
        );?>
        <?php echo $this->Form->input
          ('Place.sort_condition',
          array('type'=>'select',
                'options'=>
                      array(
                            'distance'=>'移動距離',
                            'open'=>'閉店時間までの時間',
                            'capacity'=>'収容人数',
                            'budget'=>'予算',
                            ),
                'required' => false,
                'label' => false ,
                'div' => false,
                'id' => "PlaceSortCondition",
                'class' => "form-control",
                )
          );
        ?>
        <?php echo $this->Form->end(); ?>

  </div>
  
  <div class="row">

    <?php echo $this->Places->loop_data($data,$location) ;?>

  </div>

  <hr>

</div> <!-- /container -->

  <!-- script references -->
    <?php echo $this->Html->script('jquery-2.1.1.js'); ?>
    <?php echo $this->Html->script('bootstrap.js'); ?>
  </body>
</html>