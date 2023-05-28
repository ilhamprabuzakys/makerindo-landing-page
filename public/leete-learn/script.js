function generateMatrix() {
   const X = parseInt(prompt("Masukkan Nilai X:"));
   const Y = parseInt(prompt("Masukkan Nilai Y:"));
 
   const matrix = [];
 
   for (let i = 0; i < Y; i++) {
     matrix[i] = [];
     for (let j = 0; j < X; j++) {
       const input = parseInt(prompt(`Masukkan nilai pada (${i + 1},${j + 1}) =`));
       matrix[i][j] = input;
     }
   }
 
   let output = "";
   for (let i = 0; i < Y; i++) {
     output += "[";
     for (let j = 0; j < X; j++) {
       output += matrix[i][j];
       if (j < X - 1) {
         output += "\t";
       }
     }
     output += "],\n";
   }
 
   alert(`Skema Matriks ${X} x ${Y}:\n${output}`);
 }
 