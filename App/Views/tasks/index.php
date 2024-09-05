<?php  include(VIEWS.'inc'.DS.'header.php'); ?>

<main id="mainContainer">
    <section id="wrapper">
        <input class="input" type="text" placeholder="Enter a new task" aria-label="Task input">
        <button class="addBtn" id="add-btn" aria-label="Add a task">Add a task</button>
    </section>
    <ul id="unorderedListOfTasks"></ul>
</main>

<?php  include(VIEWS.'inc'.DS.'footer.php'); ?>
