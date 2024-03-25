<!-- dashboard.ctp -->
<h2>Welcome to the Dashboard</h2>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Most Asked Questions</div>
            <div class="card-body">
                <!-- Display most asked questions here -->
                <ul>
                    <?php foreach ($mostAskedQuestions as $question) : ?>
                        <li><?php echo h($question->questions); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Top 5 Answers</div>
            <div class="card-body">
                <!-- Display top 5 answers here -->
                <ol>
                    
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Additional content for the dashboard -->