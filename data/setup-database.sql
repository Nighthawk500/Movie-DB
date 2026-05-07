-- Database setup file
-- This file creates the movie_db database and the movies table if they do not already exist.

CREATE DATABASE IF NOT EXISTS movie_db;
USE movie_db;

CREATE TABLE IF NOT EXISTS movies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rank_num INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    opening INT NOT NULL,
    total_gross INT NOT NULL,
    percent_total DECIMAL(5,2) NOT NULL,
    theaters INT NOT NULL,
    average INT NOT NULL,
    release_date VARCHAR(50) NOT NULL,
    distributor VARCHAR(255) NOT NULL
);


-- Inserting data from data.csv
INSERT INTO movies (rank_num, title, opening, total_gross, percent_total, theaters, average, release_date, distributor) VALUES (1, 'Avengers: Endgame', 357115007, 858373000, 41.6, 4662, 76601, '2019-04-26', 'Walt Disney Studios Motion Pictures');
INSERT INTO movies (rank_num, title, opening, total_gross, percent_total, theaters, average, release_date, distributor) VALUES (2, 'Spider-Man: No Way Home', 260138569, 804793477, 32.3, 4336, 59995, '2021-12-17', 'Sony Pictures Releasing');
INSERT INTO movies (rank_num, title, opening, total_gross, percent_total, theaters, average, release_date, distributor) VALUES (3, 'Avengers: Infinity War', 257698183, 678815482, 38, 4474, 57599, '2018-04-27', 'Walt Disney Studios Motion Pictures');
INSERT INTO movies (rank_num, title, opening, total_gross, percent_total, theaters, average, release_date, distributor) VALUES (4, 'Star Wars: Episode VII - The Force Awakens', 247966675, 936662225, 26.5, 4134, 59982, '2015-12-18', 'Walt Disney Studios Motion Pictures');
INSERT INTO movies (rank_num, title, opening, total_gross, percent_total, theaters, average, release_date, distributor) VALUES (5, 'Star Wars: Episode VIII - The Last Jedi', 220009584, 620181382, 35.5, 4232, 51987, '2017-12-15', 'Walt Disney Studios Motion Pictures');
INSERT INTO movies (rank_num, title, opening, total_gross, percent_total, theaters, average, release_date, distributor) VALUES (6, 'Deadpool & Wolverine', 211435291, 636745858, 33.2, 4210, 50222, '2024-07-26', 'Walt Disney Studios Motion Pictures');
INSERT INTO movies (rank_num, title, opening, total_gross, percent_total, theaters, average, release_date, distributor) VALUES (7, 'Jurassic World', 208806270, 652270625, 32, 4274, 48855, '2015-06-12', 'Universal Pictures');
INSERT INTO movies (rank_num, title, opening, total_gross, percent_total, theaters, average, release_date, distributor) VALUES (8, 'The Avengers', 207438708, 623357910, 33.3, 4349, 47698, '2012-05-04', 'Walt Disney Studios Motion Pictures');
INSERT INTO movies (rank_num, title, opening, total_gross, percent_total, theaters, average, release_date, distributor) VALUES (9, 'Black Panther', 202003951, 700059566, 28.9, 4020, 50249, '2018-02-16', 'Walt Disney Studios Motion Pictures');
INSERT INTO movies (rank_num, title, opening, total_gross, percent_total, theaters, average, release_date, distributor) VALUES (10, 'The Lion King', 191770759, 543638043, 35.3, 4725, 40586, '2019-07-19', 'Walt Disney Studios Motion Pictures');
INSERT INTO movies (rank_num, title, opening, total_gross, percent_total, theaters, average, release_date, distributor) VALUES (11, 'Avengers: Age of Ultron', 191271109, 459005868, 41.7, 4276, 44731, '2015-05-01', 'Walt Disney Studios Motion Pictures');
INSERT INTO movies (rank_num, title, opening, total_gross, percent_total, theaters, average, release_date, distributor) VALUES (12, 'Doctor Strange in the Multiverse of Madness', 187420998, 411331607, 45.6, 4534, 41336, '2022-05-06', 'Walt Disney Studios Motion Pictures');
INSERT INTO movies (rank_num, title, opening, total_gross, percent_total, theaters, average, release_date, distributor) VALUES (13, 'Incredibles 2', 182687905, 608581744, 30, 4410, 41425, '2018-06-15', 'Walt Disney Studios Motion Pictures');
INSERT INTO movies (rank_num, title, opening, total_gross, percent_total, theaters, average, release_date, distributor) VALUES (14, 'Black Panther: Wakanda Forever', 181339761, 453829060, 40, 4396, 41251, '2022-11-11', 'Walt Disney Studios Motion Pictures');
INSERT INTO movies (rank_num, title, opening, total_gross, percent_total, theaters, average, release_date, distributor) VALUES (15, 'Captain America: Civil War', 179139142, 408084349, 43.9, 4226, 42389, '2016-05-06', 'Walt Disney Studios Motion Pictures');
INSERT INTO movies (rank_num, title, opening, total_gross, percent_total, theaters, average, release_date, distributor) VALUES (16, 'Star Wars: Episode IX - The Rise of Skywalker', 177383864, 515202542, 34.4, 4406, 40259, '2019-12-20', 'Walt Disney Studios Motion Pictures');
INSERT INTO movies (rank_num, title, opening, total_gross, percent_total, theaters, average, release_date, distributor) VALUES (17, 'Beauty and the Beast', 174750616, 504014165, 34.7, 4210, 41508, '2017-03-17', 'Walt Disney Studios Motion Pictures');
INSERT INTO movies (rank_num, title, opening, total_gross, percent_total, theaters, average, release_date, distributor) VALUES (18, 'Iron Man 3', 174144585, 409013994, 42.6, 4253, 40946, '2013-05-03', 'Walt Disney Studios Motion Pictures');
INSERT INTO movies (rank_num, title, opening, total_gross, percent_total, theaters, average, release_date, distributor) VALUES (19, 'Harry Potter and the Deathly Hallows: Part 2', 169189427, 381011219, 44.4, 4375, 38671, '2011-07-15', 'Warner Bros.');
INSERT INTO movies (rank_num, title, opening, total_gross, percent_total, theaters, average, release_date, distributor) VALUES (20, 'Batman v Superman: Dawn of Justice', 166007347, 330360194, 50.2, 4242, 39134, '2016-03-25', 'Warner Bros.');
INSERT INTO movies (rank_num, title, opening, total_gross, percent_total, theaters, average, release_date, distributor) VALUES (21, 'A Minecraft Movie', 162753003, 424087780, 38.4, 4263, 38178, '2025-04-04', 'Warner Bros.');
INSERT INTO movies (rank_num, title, opening, total_gross, percent_total, theaters, average, release_date, distributor) VALUES (22, 'Barbie', 162022044, 636238421, 25.5, 4243, 38185, '2023-07-21', 'Warner Bros.');
INSERT INTO movies (rank_num, title, opening, total_gross, percent_total, theaters, average, release_date, distributor) VALUES (23, 'The Dark Knight Rises', 160887295, 448139099, 35.9, 4404, 36532, '2012-07-20', 'Warner Bros.');
INSERT INTO movies (rank_num, title, opening, total_gross, percent_total, theaters, average, release_date, distributor) VALUES (24, 'The Dark Knight', 158411483, 533345358, 29.7, 4366, 36282, '2008-07-18', 'Warner Bros.');
INSERT INTO movies (rank_num, title, opening, total_gross, percent_total, theaters, average, release_date, distributor) VALUES (25, 'The Hunger Games: Catching Fire', 158074286, 424668047, 37.2, 4163, 37971, '2013-11-22', 'Lionsgate');
INSERT INTO movies (rank_num, title, opening, total_gross, percent_total, theaters, average, release_date, distributor) VALUES (26, 'Rogue One: A Star Wars Story', 155081681, 532177324, 29.1, 4157, 37306, '2016-12-16', 'Walt Disney Studios Motion Pictures');
INSERT INTO movies (rank_num, title, opening, total_gross, percent_total, theaters, average, release_date, distributor) VALUES (27, 'Inside Out 2', 154201673, 652980194, 23.6, 4440, 34730, '2024-06-14', 'Walt Disney Studios Motion Pictures');
INSERT INTO movies (rank_num, title, opening, total_gross, percent_total, theaters, average, release_date, distributor) VALUES (28, 'Captain Marvel', 153433423, 426829839, 36, 4310, 35599, '2019-03-08', 'Walt Disney Studios Motion Pictures');
INSERT INTO movies (rank_num, title, opening, total_gross, percent_total, theaters, average, release_date, distributor) VALUES (29, 'The Hunger Games', 152535747, 408010692, 37.4, 4137, 36871, '2012-03-23', 'Lionsgate');
INSERT INTO movies (rank_num, title, opening, total_gross, percent_total, theaters, average, release_date, distributor) VALUES (30, 'Spider-Man 3', 151116516, 336530303, 44.9, 4252, 35540, '2007-05-04', 'Sony Pictures Releasing');
