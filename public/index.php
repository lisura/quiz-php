<?php
define('DS', DIRECTORY_SEPARATOR);
chdir(realpath(__DIR__ . DS . '../'));

require 'vendor/autoload.php';


try {
    $bootstrap = \Quiz\Bootstrap::getInstance();
    $showMan = new \Quiz\ShowMan();
    $random_questions = $showMan->getRandonQuestions();

    $order = $random_questions['order'];
    $questions = $random_questions['questions'];

    
} catch (Exception $ex) {

    echo "<pre>" . print_r($ex, 1) . "</pre>";
    die(__FILE__ . '[' . __LINE__ . ']');
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Quiz - PHP</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="./css/quiz.css">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        <script src="./js/php-quiz.js"></script>
    </head>
    <body class="qz-body-main" role="document">
        <nav class="navbar navbar-inverse navbar-fixed-top hidden-print">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">Quiz-PHP</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">Home</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Questões <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <?php
                                foreach ($order as $ordem => $question_idx) : ?>
                                <li><a href="#question-<?php echo $ordem?>">Question - <?php echo $ordem;?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <div class="container">
            <div class="page-header">
                <h1>Questões</h1>
            </div>
            
            <?php 
            foreach ($order as $ordem => $question_idx) : 
                $question = $questions[$question_idx];
            ?>
            <div class="row">
                <div class="panel panel-primary question" id="question-<?=$ordem?>">
                    <div class="panel-heading heading-question" data-question="question-<?=$ordem?>">
                        <h3 class="panel-title">Questão - <?php echo $ordem?>:</h3>
                    </div>
                    <div class="panel-body body-question" id="body-question-<?=$ordem?>">
                        
                        <div class="well qz-question">
                            <h2><?php echo $question->getQuestion()?></h2>
                        </div>
                        
                        <?php if($question->getFileCodeSample()): ?>
                        <div style="">
                            <pre class="qz-question-samplecode" >
                                <?php echo $question->getHighlightCodeSample ()?>
                            </pre>
                        </div>
                        <?php endif; ?>
                        
                        <?php if($question->getMultipleChoices()) : ?>
                        <div class="well qz-question qz-choices-<?=$ordem?>">
                            <?php
                                $letra = 'A';
                                foreach ($question->getMultipleChoices() as $key => $choice) : 
                            ?>
                                <p id="choice-<?=$key?>" class='choice'>
                                    <?php echo "$letra) - $choice"; $letra++; ?>
                                </p>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                        
                        <div class="well qz-question clearfix" id="a<?=$ordem?>">
                            <button class="btn btn-primary btn-solveit pull-right" data-qid="<?=$ordem?>" data-aid="<?=json_encode($question->getAnswer())?>">solve it.</button>
                        </div>
                
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            
        </div>
        
    </body>

</html>

