<?php if(isset($counter)): ?>
    <h1>{{ $counter }}</h1>
<?php endif ?>

<?php if(isset($video)): ?>
    <h1>Video has been download {{ $video }} time </h1>
<?php else: ?>
    <h1>Video has been download 0 time </h1>
<?php endif ?>

