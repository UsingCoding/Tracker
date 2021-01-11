import numpy as np
import skfuzzy as fuzz

class FuzzyService:
    def __init__(self):
        pass

    def calculate(self, diff, time):

        if not isinstance(diff, int) or not isinstance(time, int):
            raise ValueError('')

        difficulty = np.arange(0, 11, 1)
        requiredTime = np.arange(0, 41, 1)
        employeeLevel  = np.arange(0, 11, 1)

        easyDifficulty = fuzz.trimf(difficulty, [0, 0, 5])
        mediumDifficulty = fuzz.trimf(difficulty, [3, 6, 8])
        hardDifficulty = fuzz.trimf(difficulty, [6, 10, 10])

        veryShortRequiredTime = fuzz.trimf(requiredTime, [0, 0, 3])
        shortRequiredTime = fuzz.trimf(requiredTime, [2, 4, 6])
        usualRequiredTime = fuzz.trimf(requiredTime, [4, 7, 10])
        longRequiredTime = fuzz.trimf(requiredTime, [8, 20, 32])
        veryLongRequiredTime = fuzz.trimf(requiredTime, [28, 40, 40])

        juniorEmployeeLevel = fuzz.trimf(employeeLevel, [0, 0, 4])
        middleEmployeeLevel = fuzz.trimf(employeeLevel, [3, 5, 7])
        seniorEmployeeLevel = fuzz.trimf(employeeLevel, [6, 7, 9])
        architectEmployeeLevel = fuzz.trimf(employeeLevel, [8, 10, 10])

        diff_level_lo = fuzz.interp_membership(difficulty, easyDifficulty, diff)
        diff_level_md = fuzz.interp_membership(difficulty, mediumDifficulty, diff)
        diff_level_hi = fuzz.interp_membership(difficulty, hardDifficulty, diff)

        time_level_veryShort = fuzz.interp_membership(requiredTime, veryShortRequiredTime, time)
        time_level_short = fuzz.interp_membership(requiredTime, shortRequiredTime, time)
        time_level_usual = fuzz.interp_membership(requiredTime, usualRequiredTime, time)
        time_level_long = fuzz.interp_membership(requiredTime, longRequiredTime, time)
        time_level_veryLong = fuzz.interp_membership(requiredTime, veryLongRequiredTime, time)

        active_rule1 = np.fmin(diff_level_lo, time_level_veryShort)
        employeeLevel_activation1 = np.fmin(active_rule1, middleEmployeeLevel)

        active_rule2 = np.fmin(diff_level_lo, time_level_short)
        employeeLevel_activation2 = np.fmin(active_rule2, juniorEmployeeLevel)

        active_rule3 = np.fmin(diff_level_lo, time_level_usual)
        employeeLevel_activation3 = np.fmin(active_rule3, juniorEmployeeLevel)

        active_rule4 = np.fmin(diff_level_lo, time_level_long)
        employeeLevel_activation4 = np.fmin(active_rule4, juniorEmployeeLevel)

        active_rule5 = np.fmin(diff_level_lo, time_level_veryLong)
        employeeLevel_activation5 = np.fmin(active_rule5, juniorEmployeeLevel)

        active_rule6 = np.fmin(diff_level_md, time_level_veryShort)
        employeeLevel_activation6 = np.fmin(active_rule6, seniorEmployeeLevel)

        active_rule7 = np.fmin(diff_level_md, time_level_short)
        employeeLevel_activation7 = np.fmin(active_rule7, middleEmployeeLevel)

        active_rule8 = np.fmin(diff_level_md, time_level_usual)
        employeeLevel_activation8 = np.fmin(active_rule8, middleEmployeeLevel)

        active_rule9 = np.fmin(diff_level_md, time_level_long)
        employeeLevel_activation9 = np.fmin(active_rule9, juniorEmployeeLevel)

        active_rule10 = np.fmin(diff_level_md, time_level_veryLong)
        employeeLevel_activation10 = np.fmin(active_rule10, juniorEmployeeLevel)

        active_rule11 = np.fmin(diff_level_hi, time_level_veryShort)
        employeeLevel_activation11 = np.fmin(active_rule11, architectEmployeeLevel)

        active_rule12 = np.fmin(diff_level_hi, time_level_short)
        employeeLevel_activation12 = np.fmin(active_rule12, seniorEmployeeLevel)

        active_rule13 = np.fmin(diff_level_hi, time_level_usual)
        employeeLevel_activation13 = np.fmin(active_rule13, seniorEmployeeLevel)

        active_rule14 = np.fmin(diff_level_hi, time_level_long)
        employeeLevel_activation14 = np.fmin(active_rule14, seniorEmployeeLevel)

        active_rule15 = np.fmin(diff_level_hi, time_level_veryLong)
        employeeLevel_activation15 = np.fmin(active_rule15, architectEmployeeLevel)

        aggregated = employeeLevel_activation15

        for level_activation in (employeeLevel_activation14, employeeLevel_activation13, employeeLevel_activation12,
         employeeLevel_activation13, employeeLevel_activation12, employeeLevel_activation11, employeeLevel_activation10, employeeLevel_activation9,
         employeeLevel_activation8, employeeLevel_activation7, employeeLevel_activation6, employeeLevel_activation5, employeeLevel_activation4,
         employeeLevel_activation3, employeeLevel_activation2, employeeLevel_activation1):
            aggregated = np.fmax(level_activation, aggregated)

        result = fuzz.defuzz(employeeLevel, aggregated, 'centroid')

        return result