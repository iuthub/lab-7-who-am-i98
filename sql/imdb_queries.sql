1. SELECT name FROM `movies` WHERE year=1995
2. SELECT COUNT(actor_id) FROM roles WHERE roles.movie_id=(SELECT id FROM movies WHERE movies.name="Lost in Translation")
3. SELECT actors.first_name FROM actors JOIN roles ON roles.actor_id=actors.id WHERE roles.movie_id=(SELECT id FROM movies WHERE movies.name="Lost in Translation")
4. SELECT directors.first_name FROM directors JOIN movies_directors ON directors.id=movies_directors.director_id WHERE movies_directors.movie_id=(SELECT id FROM movies WHERE movies.name="Fight Club")
5. SELECT movies_directors.movie_id FROM movies_directors WHERE movies_directors.director_id=(SELECT id FROM directors WHERE directors.first_name="Clint" AND directors.last_name="Eastwood")
6. SELECT movies.name FROM movies JOIN movies_directors ON movies.id=movies_directors.movie_id WHERE movies_directors.director_id=(SELECT id FROM directors WHERE directors.first_name="Clint" AND directors.last_name="Eastwood")
7. SELECT directors.first_name FROM directors JOIN directors_genres ON directors_genres.director_id=directors.id WHERE directors_genres.genre="Horror"
8. SELECT first_name, last_name FROM actors where id IN(SELECT actor_id from roles where movie_id in(SELECT movie_id FROM movies_directors where director_id in(SELECT id FROM directors where first_name="Christopher" and last_name="Nolan")))
