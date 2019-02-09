CREATE TABLE users (
     user_id   SERIAL PRIMARY KEY
   , fname     VARCHAR(12) NOT NULL
   , lname     VARCHAR(15) NOT NULL
   , email     VARCHAR(64) NOT NULL
   , hash      VARCHAR(255) NOT NULL
);

CREATE TABLE buildings (
     building_id     SERIAL PRIMARY KEY
   , building_name   VARCHAR(25) NOT NULL
   , floor_num       INTEGER     NOT NULL
);

CREATE TABLE bathrooms (
     bathroom_id      SERIAL  PRIMARY KEY
   , building_id      INTEGER REFERENCES buildings(building_id) 
);

CREATE TABLE ratings (
     rating_id       SERIAL  PRIMARY KEY
   , building_id     INTEGER REFERENCES buildings(building_id)
   , bathroom_id     INTEGER REFERENCES bathrooms(bathroom_id)
   , integrity_value INTEGER
   , overall_score   INTEGER NOT NULL
     CHECK (overall_score >= 0 AND overall_score <= 5)
   , cleanliness     INTEGER NOT NULL
     CHECK (cleanliness >= 1 AND cleanliness <= 5)
   , traffic         INTEGER
     CHECK (traffic >= 1 AND traffic <= 5)
   , echo_value      INTEGER
     CHECK (echo_value >= 1 AND echo_value <= 5)
   , stocked         BOOLEAN 
   , broken          BOOLEAN
   , single_stall    BOOLEAN
);