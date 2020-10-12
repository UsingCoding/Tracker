import numpy as np
import skfuzzy as fuzz
import matplotlib.pyplot as plt

class Model:
    def __init__(self):

        difficulty = np.arange(0, 10, 1)
        requiredTime = np.arange(0, 40, 1)
        employeeLevel  = np.arange(0, 10, 1)

        easyDifficulty = fuzz.trimf(difficulty, [0, 4, 5])
        mediumDifficulty = fuzz.trimf(difficulty, [4, 8, 10])
        hardDifficulty = fuzz.trimf(difficulty, [7, 10, 10])

        veryShortRequiredTime = fuzz.trimf(requiredTime, [0, 3, 5])
        shortRequiredTime = fuzz.trimf(requiredTime, [2, 6, 10])
        usualRequiredTime = fuzz.trimf(requiredTime, [4, 10, 11])
        longRequiredTime = fuzz.trimf(requiredTime, [8, 32, 40])
        veryLongRequiredTime = fuzz.trimf(requiredTime, [28, 40, 40])

        juniorEmployeeLevel = fuzz.trimf(employeeLevel, [0, 4, 5])
        middleEmployeeLevel = fuzz.trimf(employeeLevel, [3, 7, 10])
        seniorEmployeeLevel = fuzz.trimf(employeeLevel, [6, 9, 10])
        architectEmployeeLevel = fuzz.trimf(employeeLevel, [9, 10, 10])

        fig, (ax0, ax1, ax2) = plt.subplots(nrows=3, figsize=(8, 9))

        ax0.plot(difficulty, easyDifficulty, 'b', linewidth=1.5, label='Easy')
        ax0.plot(difficulty, mediumDifficulty, 'g', linewidth=1.5, label='Medium')
        ax0.plot(difficulty, hardDifficulty, 'r', linewidth=1.5, label='Hard')
        ax0.set_title('Difficulty')
        ax0.legend()

        ax1.plot(requiredTime, veryShortRequiredTime, 'b', linewidth=1.5, label='Very Short')
        ax1.plot(requiredTime, shortRequiredTime, 'g', linewidth=1.5, label='Short')
        ax1.plot(requiredTime, usualRequiredTime, 'r', linewidth=1.5, label='Usual')
        ax1.plot(requiredTime, longRequiredTime, 'b', linewidth=1.5, label='Long')
        ax1.plot(requiredTime, veryLongRequiredTime, 'y', linewidth=1.5, label='Very short')
        ax1.set_title('Required time')
        ax1.legend()

        ax2.plot(employeeLevel, juniorEmployeeLevel, 'b', linewidth=1.5, label='Junior')
        ax2.plot(employeeLevel, middleEmployeeLevel, 'g', linewidth=1.5, label='Middle')
        ax2.plot(employeeLevel, seniorEmployeeLevel, 'r', linewidth=1.5, label='Senior')
        ax2.plot(employeeLevel, architectEmployeeLevel, 'y', linewidth=1.5, label='Architect')
        ax2.set_title('Employee level')
        ax2.legend()

# Turn off top/right axes
for ax in (ax0, ax1, ax2):
    ax.spines['top'].set_visible(False)
    ax.spines['right'].set_visible(False)
    ax.get_xaxis().tick_bottom()
    ax.get_yaxis().tick_left()

    plt.tight_layout()

    def initVariables(self):
        pass