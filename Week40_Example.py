#A function that takes in the club to search for, the club list, and the points list
def find_club_points(club_name, clubs, points):
  index = -1     # -1 means the data hasn't been found
  for i in range(0,len(clubs)):  # a loop from the start to end of the clubs list
    print("checking item ", i)
    
    if club_name == clubs[i]:
      index = i #this is the position that the data was found
  if index == -1:
    return "not in list" #return error message
  else:
    return points[index] # return the number of points for the club
    
  
# ====================== MAIN PROGRAM ===============================
  
#1D array of STRING to hold club names
clubs = ["Tigers", "Lions", "Eagles", "Sharks", "Wolves"] 

#2D array of INTEGER showing won, draw, & lost in each row
statistics = [[6, 4, 2], [5, 6, 1], [4, 5, 3], [3, 3, 6], [2, 7, 3]]

points = []

#the for loop will iterate (loop) through each club in the clubs array
for i in range(0,len(clubs)):
  #the i in the 1st square brackets is the club's index
  print("Calculating item ", i)
  win = statistics[i][0] * 3 # get the number of wins and multiply by 3 points 
  draw = statistics[i][1] # 1 point for a draw means the count is enough
  total_points = win + draw
  points.append(total_points)
  print(points)
  
club_total_points = find_club_points("Eagles",clubs, points)
print("Eagles won ", statistics[2][0], " games and scored ", club_total_points, "points")