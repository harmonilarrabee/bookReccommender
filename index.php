<head>
    <title>Book Recommender</title>
    <script src="https://unpkg.com/vue"></script>
    <style>
    body {
        font-family: Georgia;
        background-color: #e8e1ef;
        text-align: center;
    }
    .title {
        margin-top: 20px;
        margin-bottom: 40px;
        margin-right: 40px;
        margin-left: 40px;
        font-size: 48px;
    }
    .subtitle {
        margin: 20px;
        font-size: 24px;
    }
    .box {
        margin-bottom: 40px;
        margin-right: 40px;
        margin-left: 40px;
        border: 2px solid black;
        border-radius: 4px;
    }
    .wrapper {
        margin: 20px;
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
    }
    .wrapper div {
        margin: 10px;
        display: flex;
    }
    .button {
        margin-bottom: 40px;
        margin-right: 40px;
        margin-left: 40px;
        display: flex;
        justify-content: space-around;
    }
    table, th, td {
    border: 1px solid black;
    }
    </style>
</head>

<body>
    <div id = "app">
        <div class="title">Book Recommender</div>
        <div class="subtitle">Welcome to Book Recommender! Please select an option for each of the book traits below, 
        then click submit to see a list of books that match your selections. </div>
        <div class="box">
            <div class="wrapper">
                <div class="dropdown" v-for="trait in traits">
                    <div class="label">Select a {{ trait.title }}:</div>
                    <select v-model="trait.selected">
                        <option v-for="option in trait.options" :value="option">{{ option }}</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="button">
            <button type="button" v-on:click="isHidden = false">Submit</button>
        </div>

        <div v-if="!isHidden">
            <div class="subtitle">Selected Traits:</div>
            <div class="box">
                <div class="wrapper">
                    <div v-for="trait in traits">Selected {{ trait.title }}: {{ trait.selected }}</div>
                </div>
            </div>
            <div class="subtitle">Results:</div>
            <div class="wrapper">
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "1234";
                $dbname = "book_database";

                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }


                $sql = "SELECT book.title, book.author, genre1.name AS genre1, genre2.name AS genre2, 
                topic1.name AS topic1, topic2.name AS topic2, topic3.name AS topic3, topic4.name AS topic4, 
                topic5.name AS topic5, page_length.name AS page_length, series.name AS series
                FROM book JOIN genre AS genre1 ON book.genre1 = genre1.id JOIN genre AS genre2 ON book.genre2 = genre2.id
                JOIN topic AS topic1 ON book.topic1 = topic1.id JOIN topic AS topic2 ON book.topic2 = topic2.id 
                JOIN topic AS topic3 ON book.topic3 = topic3.id JOIN topic AS topic4 ON book.topic4 = topic4.id 
                JOIN topic AS topic5 ON book.topic5 = topic5.id JOIN page_length ON book.page_length = page_length.id 
                JOIN series ON book.series = series.id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo "<table><tr><th>Title</th><th>Author</th><th>Genre One</th><th>Genre Two</th><th>Topic One</th>
                    <th>Topic Two</th><th>Topic Three</th><th>Topic Four</th><th>Topic Five</th><th>Page Length</th>
                    <th>Series</th></tr>";
                    while($row = $result->fetch_assoc()) {
                        echo "<tr><td>" . $row["title"]. "</td><td>" . $row["author"]. "</td><td>" . $row["genre1"]. "</td>
                        <td>" . $row["genre2"]. "</td><td>" . $row["topic1"]. "</td><td>" . $row["topic2"]. "</td>
                        <td>" . $row["topic3"]. "</td><td>" . $row["topic4"]. "</td><td>" . $row["topic5"]. "</td>
                        <td>" . $row["page_length"]. "</td><td>" . $row["series"]. "</td></tr>";
                    }
                    echo "</table>";
                } else {
                    echo "We're sorry, no books in our database match all the traits you selected.";
                }
                $conn->close();
                ?>
            </div>
        </div>
    </div>

    <script>
        ;

        var traits = [
            {
                title: "Genre",
                selected: "",
                options: [
                    "Realistic Fiction",
                    "Fantasy",
                    "Science Fiction",
                    "Dystopia",
                    "Historical Fiction",
                    "Mystery",
                    "Romance",
                    "Classic",
                    "No Preference",
                ],
            },{
                title: "Topic",
                selected: "",
                options: [
                    "Death",
                    "Love",
                    "Family",
                    "Friendship",
                    "Coming of Age",
                    "Change",
                    "Power",
                    "Rebellion",
                    "Adventure",
                    "Good vs. Evil",
                    "No Preference",
                ]
            },{
                title: "Page Length",
                selected: "",
                options: [
                    "Less than 100",
                    "101-150",
                    "151-200",
                    "201-250",
                    "251-300",
                    "301-350",
                    "351-400",
                    "401-450",
                    "451-500",
                    "More than 500",
                    "No Preference",
                ],
            },{
                title: "Series Option",
                selected: "",
                options: [
                    "Part of a Series",
                    "Not Part of a Series",
                    "No Preference",
                ]
            },
        ];

        var app = new Vue({
            el: '#app',
            data: {
                traits: traits,
                isHidden: true,
            },
            methods: {
                
            },
        });
    </script>
</body>