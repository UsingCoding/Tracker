### How to run

In `~dev/` run to up docker containers with fuzzy service
````shell
docker-compose up -d 
````

### What this about

This module uses [Fuzzy logic](https://en.wikipedia.org/wiki/Fuzzy_logic) to calculate developer level 
with specific terms and rules.

#### Terms

`"term-name": term-range`

* By task complexity

```shell
"easy": [0:4],
"medium": [4:8],
"hard": [7:10],
```

* By time to complete the task

```shell
"very urgent": [0h,3h],
"urgent" : [2h:6h],
"usual": [4h:10h],
"long": [1d:4d]
"very long": [3.5d:1w]
```

* By employee level

```shell
"Junior": [0,4],
"Middle": [3,7],
"Senior": [6,9],
"Architect": [8,10]
```

#### Rules
By these rules receive employee level  
```shell
easy && very urgent = middle
easy && urgent = junior
easy && usual = junior
easy && long = junior
easy && very long = junior
-------------------------------------------
medium && very urgent = senior
medium && urgent = middle
medium && usual = middle 
medium && long = junior
medium && very long = junior
-------------------------------------------
hard && very urgent = architect
hard && urgent = senior
hard && usual = senior
hard && long = senior
hard && very long = architect
```

### How to use in other project

* Main calculation and business logic places in `fuzzy/src/Domain/FuzzyService.py`, 
  so you can just copy this file to your project
* Method `FuzzyService::calculate` accepts difficulty and time an integer. 
  If passed not integers, method throws a ValueError.

#### Required dependencies

* Python3^
* numpy
* skfuzzy

#### Install dependencies

Run only if you want to use Domain in another application  

````shell
pip install numpy
pip install scikit-fuzzy