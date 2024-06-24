
# Secretlab Tech Exercise

## Badges

![CI](https://github.com/eamoto/secretlab-exercise-uy4cgn1i42y1gc0cjrqy/actions/workflows/staging-deployment.yml/badge.svg)

![CI](https://github.com/eamoto/secretlab-exercise-uy4cgn1i42y1gc0cjrqy/actions/workflows/production-deployment.yml/badge.svg)

Staging:
[![codecov](https://codecov.io/gh/eamoto/secretlab-exercise-uy4cgn1i42y1gc0cjrqy/staging/main/graph/badge.svg)](https://codecov.io/gh/eamoto/secretlab-exercise-uy4cgn1i42y1gc0cjrqy)

Master:
[![codecov](https://codecov.io/gh/eamoto/secretlab-exercise-uy4cgn1i42y1gc0cjrqy/master/main/graph/badge.svg)](https://codecov.io/gh/eamoto/secretlab-exercise-uy4cgn1i42y1gc0cjrqy)


## API Reference

#### Add Object Version

```http
  POST https://phpstack-694833-4667522.cloudwaysapps.com/api/object
```

| Parameter | Type     | Description                 |
| :-------- | :------- | :-------------------------  |
| -         | `json`   | **Required**. A single-key JSON object where the key is a string and the value must be either a **string** or another **JSON**.  Numeric types for values are not permitted. |

#### Get Object Version

```http
  GET https://phpstack-694833-4667522.cloudwaysapps.com/api/object/${key}
```

| Parameter     | Type      | Description                       |
| :--------     | :-------  | :-------------------------------- |
| `timestamp`   | `integer` | **Optional**. Using a timestamp returns the value associated with the key at that specific time. |

#### Get All Object Versions

```http
  GET https://phpstack-694833-4667522.cloudwaysapps.com/api/object/get_all_records
```

Returns a JSON array containing all record data and their values currently stored in the database.