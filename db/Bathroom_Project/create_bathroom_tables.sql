CREATE TABLE users (
     user_id   SERIAL PRIMARY KEY
   , username  VARCHAR(16)  NOT NULL
   , email     VARCHAR(64)  NOT NULL
   , hash      VARCHAR(255) NOT NULL
   , is_male	 BOOLEAN		  NOT NULL
);


-- NEED TO EDIT THIS TABLE
CREATE TABLE bathrooms (
    bathroom_id     SERIAL  PRIMARY KEY
,   building_name   VARCHAR(25) NOT NULL
,   floor_value     INTEGER NOT NULL
,	  is_mens         BOOLEAN
);

CREATE TABLE ratings (
     rating_id       SERIAL  PRIMARY KEY
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

-- Insert into the floors table
INSERT INTO floors (floor_value) VALUES
  (0), -- index 1
  (1), -- index 2
  (2), -- index 3
  (3), -- index 4
  (4), -- index 5
  (5); -- index 6

-- Insert into the buildings
INSERT INTO buildings (building_name) VALUES 
  ('STC')
, ('Taylor')
, ('Austin');


-- Insert into the bathroom table
INSERT INTO bathrooms (is_mens, building_name, floor_value) VALUES
	('TRUE',  'STC',    1)	 -- Males    restroom, STC,    1st floor
,	('FALSE', 'STC',    1) 	 -- Females  restroom, STC,    1st floor
, ('TRUE',  'STC',    2)   -- Males    restroom, STC,    2st floor
, ('FALSE', 'STC',    2)   -- Females  restroom, STC,    2st floor
, ('TRUE',  'STC',    3)   -- Males    restroom, STC,    3st floor
, ('FALSE', 'STC',    3)   -- Females  restroom, STC,    3st floor
, ('TRUE',  'Taylor', 1)   -- Males    restroom, Taylor, 1st floor
, ('FALSE', 'Taylor', 1)   -- Females  restroom, Taylor, 1st floor
, ('TRUE',  'Taylor', 2)   -- Males    restroom, Taylor, 2st floor
, ('FALSE', 'Taylor', 2)   -- Females  restroom, Taylor, 2st floor
, ('TRUE',  'Austin', 0)   -- Males    restroom, Austin, Basement
, ('FALSE', 'Austin', 0)   -- Females  restroom, Austin, Basement
, ('TRUE',  'Austin', 1)   -- Males    restroom, Austin, 1st floor
, ('FALSE', 'Austin', 1)   -- Females  restroom, Austin, 1st floor
, ('TRUE',  'Austin', 2)   -- Males    restroom, Austin, 2st floor
, ('FALSE', 'Austin', 2);  -- Females  restroom, Austin, 2st floor



-- For home page query
SELECT  b.building_name
,       b.floor_value
FROM    users u
,       bathrooms b
WHERE   u.is_male = b.is_mens;
-- Will eventually include comments










