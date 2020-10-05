import numpy as np
import skfuzzy as fuzz
import matplotlib.pyplot as plt

class Model:
    def __init__(self):
        pass
#         difficulty = np.arange(0, 10, 1)
#         requiredTime = np.arange(0, 40, 1)
#         employeeLevel  = np.arange(0, 10, 1)
#
#         easyDifficulty = fuzz.trimf(difficulty, [0, 4, 5])
#         mediumDifficulty = fuzz.trimf(difficulty, [4, 8, 5])
#         hardDifficulty = fuzz.trimf(difficulty, [7, 10, 5])
#
#         veryShortRequiredTime = fuzz.trimf(requiredTime, [0, 3, 5])
#         shortRequiredTime = fuzz.trimf(requiredTime, [2, 6, 5])
#         usualRequiredTime = fuzz.trimf(requiredTime, [4, 10, 5])
#         longRequiredTime = fuzz.trimf(requiredTime, [8, 32, 5])
#         veryLongRequiredTime = fuzz.trimf(requiredTime, [28, 40, 5])
#
#         juniorEmployeeLevel = fuzz.trimf(employeeLevel, [0, 4, 5])
#         middleEmployeeLevel = fuzz.trimf(employeeLevel, [3, 7, 5])
#         seniorEmployeeLevel = fuzz.trimf(employeeLevel, [6, 9, 5])
#         architectEmployeeLevel = fuzz.trimf(employeeLevel, [9, 10, 5])
#
#         fig, (ax0, ax1, ax2) = plt.subplots(nrows=3, figsize=(8, 9))
#
#         ax0.plot(x_qual, qual_lo, 'b', linewidth=1.5, label='Bad')
#         ax0.plot(x_qual, qual_md, 'g', linewidth=1.5, label='Decent')
#         ax0.plot(x_qual, qual_hi, 'r', linewidth=1.5, label='Great')
#         ax0.set_title('Food quality')
#         ax0.legend()
#
#         ax1.plot(x_serv, serv_lo, 'b', linewidth=1.5, label='Poor')
#         ax1.plot(x_serv, serv_md, 'g', linewidth=1.5, label='Acceptable')
#         ax1.plot(x_serv, serv_hi, 'r', linewidth=1.5, label='Amazing')
#         ax1.set_title('Service quality')
#         ax1.legend()
#
#         ax2.plot(x_tip, tip_lo, 'b', linewidth=1.5, label='Low')
#         ax2.plot(x_tip, tip_md, 'g', linewidth=1.5, label='Medium')
#         ax2.plot(x_tip, tip_hi, 'r', linewidth=1.5, label='High')
#         ax2.set_title('Tip amount')
#         ax2.legend()
#
#         # Turn off top/right axes
#         for ax in (ax0, ax1, ax2):
#             ax.spines['top'].set_visible(False)
#             ax.spines['right'].set_visible(False)
#             ax.get_xaxis().tick_bottom()
#             ax.get_yaxis().tick_left()
#
#         plt.tight_layout()

    def initVariables(self):
        pass